<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Repositories\LoggingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        //dump($request);
        $maxDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $startDate = Carbon::createFromTimestamp(time())->subDay(30)->format('d/m/Y');
        $endDate = Carbon::createFromTimestamp(time())->format('d/m/Y');

        $stations = Station::all()->pluck('name', 'id');
        return view('reports', compact
        (
            'maxDate',
                'startDate',
                   'endDate',
            'stations'
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
