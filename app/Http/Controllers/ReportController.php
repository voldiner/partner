<?php

namespace App\Http\Controllers;

use App\Repositories\LoggingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
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

            $notificationRepository->createReportsNotification($reportRepository->warnings, $reportRepository->station, $message);

//            $reportRepository->moveToArchive(
//                $nameReportfile,
//                $namePlacesfile,
//                $request->get('fileReports'),
//                $request->get('filePlaces'),
//                $loggingRepository
//            );
            return response()->json($toResponce, 200);

        } catch (\Exception $e) {
            $loggingRepository->createReportsLoggingMessage($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
