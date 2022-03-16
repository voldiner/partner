<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportsSearchRequest;
use App\Models\Report;

use App\Repositories\LoggingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReportRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(ReportsSearchRequest $request, ReportRepository $reportRepository)
    {
        $urlCreatePdfList = route('reports.createList') . '?' . ($request->getQueryString());
        $stationsFromSelect = $reportRepository->getStationsForSelect();

        $reports = $reportRepository->getReportsFromQuery($request);

        $numberReport = $reportRepository->numberReport;
        $sum_report = $reportRepository->sum_report;
        $stationsSelected = $reportRepository->stationsSelected;
        $dateStart = $reportRepository->dateStart;
        $dateFinish = $reportRepository->dateFinish;
        $countReports = $reportRepository->countReports;

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
            'dateFinish',
            'urlCreatePdfList'
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

    public function createReportsList(ReportsSearchRequest $request, ReportRepository $reportRepository)
    {
        $reports = $reportRepository->getReportsFromQuery($request, false, false);

        $numberReport = $reportRepository->numberReport;
        $sum_report = $reportRepository->sum_report;
        $stationsSelected = $reportRepository->stationsSelected;
        $dateStart = $reportRepository->dateStart;
        $dateFinish = $reportRepository->dateFinish;
        $countReports = $reportRepository->countReports;

        $pdf = PDF::loadView('pdf.reportsList', compact
        (
            'reports',
            'countReports',
            'numberReport',
            'sum_report',
            'stationsSelected',
            'dateStart',
            'dateFinish'

        ));

        return $pdf->download('reportList.pdf');
    }

    public function createReportPdf($id, ReportRepository $reportRepository)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== auth()->user()->id) {
            abort(403);
        }

       $places = $reportRepository->getPlacesForCreateReportPdf($report);
       $total = $reportRepository->total;
       $countedStops = $reportRepository->countedStops;

        $pdf = PDF::loadView('pdf.report', compact('report', 'places', 'total', 'countedStops'));
        return $pdf->download('report.pdf');
    }


}
