<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportsSearchRequest;
use App\Models\Report;
use App\Models\Station;
use App\Repositories\LoggingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(ReportsSearchRequest $request)
    {
        //dump($request->all());
        $stationsFromSelect = Station::all()->pluck('name', 'id');
        $numberReport = null;
        $sum_report = null;
        $stationsSelected = null;
        $dateStart = null;
        $dateFinish = null;
        if ($request->hasAny(['sum_report','number_report','stations','data-range'])){
            $query = Report::query();
            // ---- підготовка масиву умов відбору and --------
            $conditionsAnd = [];
            if ($request->has('interval')) {
                $dateStart = Carbon::createFromFormat('d/m/Y', $request->get('dateStart'));
                $dateFinish = Carbon::createFromFormat('d/m/Y', $request->get('dateFinish'));
                $conditionsAnd[] = ['date_flight', '>=', $dateStart];
                $conditionsAnd[] = ['date_flight', '<=', $dateFinish];
            }
            if ($request->number_report) {
                $conditionsAnd[] = ['num_report', '=', $request->number_report];
                $numberReport = $request->number_report;
            }
            if ($request->sum_report) {
                $conditionsAnd[] = ['sum_tariff', '=', $request->sum_report];
                $sum_report = $request->sum_report;
            }
            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('stations')) {
                $query->whereIn('station_id',$request->get('stations'));
                $stationsSelected = Station::whereIn('id',$request->get('stations'))->get();
            }

        }else{
            // до 20 останніх записів
            $last_report = Report::query()->orderBy('id', 'desc')->first();
            if ($last_report){
                $last_reportsID = $last_report->id;
                $query = Report::query()->where('id', '>' , $last_reportsID-20);
            }else{
                $query = Report::query();
            }

        }
        $countReports = $query->count();

        $reports = $query->withCount('places')
                 ->orderBy('date_flight')
                 ->with('station')
                 ->with('places')
                 ->paginate(8)
                 ->withQueryString();

        $maxDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $startDateDefault = Carbon::createFromTimestamp(time())->subDay(30)->format('d/m/Y');
        $endDateDefault = Carbon::createFromTimestamp(time())->format('d/m/Y');

        return view('reports', compact
        (
            'maxDate',
            'startDateDefault',
            'endDateDefault',
            'stationsFromSelect',
            'reports',
            'countReports',
            'numberReport',
            'sum_report',
            'stationsSelected',
            'dateStart',
            'dateFinish'
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *  приклад виклику http://partner:81/reports/create?fileReports=reports1.dbf&filePlaces=places1.dbf
     */
    public function createReports(
        Request $request,
        ReportRepository $reportRepository,
        NotificationRepository $notificationRepository,
        LoggingRepository $loggingRepository
    )
    {
        if (!$request->has('fileReports')) {
            $message = 'get parameter fileReports  not exist';
            $loggingRepository->createReportsLoggingMessage($message);
            return response()->json(['error' => $message], 404);
        }
        if (!$request->has('filePlaces')) {
            $message = 'get parameter filePlaces  not exist';
            $loggingRepository->createReportsLoggingMessage($message);
            return response()->json(['error' => $message], 404);
        }

        $nameReportfile = 'downloads/' . $request->get('fileReports');
        $namePlacesfile = 'downloads/' . $request->get('filePlaces');

        if (Storage::missing($nameReportfile)) {
            $message = $nameReportfile . ' not exist';
            $loggingRepository->createReportsLoggingMessage($message);
            return response()->json(['error' => $message], 404);
        }
        if (Storage::missing($namePlacesfile)) {
            $message = $namePlacesfile . ' not exist';
            $loggingRepository->createReportsLoggingMessage($message);
            return response()->json(['error' => $message], 404);
        }

        try {

            $message = $reportRepository->createReports($nameReportfile, $namePlacesfile);

            $loggingRepository->createReportsLoggingMessage($message);
            $loggingRepository->createReportsLoggingMessages($reportRepository->warnings);

            $toResponce = $reportRepository->createDataResponce($message, $reportRepository->warnings);

            $notificationRepository->createReportsNotification($reportRepository->warnings, $message);

            $reportRepository->moveToArchive(
                $nameReportfile,
                $namePlacesfile,
                $request->get('fileReports'),
                $request->get('filePlaces'),
                $loggingRepository
            );
            return response()->json($toResponce, 200);

        } catch (\Exception $e) {
            $loggingRepository->createReportsLoggingMessage($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
