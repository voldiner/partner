<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReportsSearchRequest;
use App\Models\Report;
use App\Http\Controllers\Controller as Controller;
use App\Repositories\Admin\ReportRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(ReportsSearchRequest $request, ReportRepository $reportRepository)
    {
        $urlCreatePdfList = route('manager.reports.createList') . '?' . ($request->getQueryString());
        $stationsFromSelect = $reportRepository->getStationsForSelect();

        $reports = $reportRepository->getReportsFromQuery($request);

        $numberReport = $reportRepository->numberReport;
        $sum_report = $reportRepository->sum_report;
        $stationsSelected = $reportRepository->stationsSelected;
        $dateStart = $reportRepository->dateStart;
        $dateFinish = $reportRepository->dateFinish;
        $countReports = $reportRepository->countReports;
        $message = $reportRepository->message;
        $maxDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $startDateDefault = Carbon::createFromTimestamp(time())->subDay(30)->format('d/m/Y');
        $endDateDefault = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $users = $reportRepository->getUsersToSelect();
        return view('admin.reports', compact
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
            'urlCreatePdfList',
            'users',
            'message'
        ));
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

       /* if (session()->has('atpId')){
            if ($report->user_id !== session('atpId')) {
                abort(403);
            }
        }*/

       $places = $reportRepository->getPlacesForCreateReportPdf($report);
       $total = $reportRepository->total;
       $countedStops = $reportRepository->countedStops;

        $pdf = PDF::loadView('pdf.report', compact('report', 'places', 'total', 'countedStops'));
        return $pdf->download('report.pdf');
    }


}
