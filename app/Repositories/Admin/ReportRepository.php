<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2022
 * Time: 19:34
 */

namespace App\Repositories\Admin;


use App\Http\Requests\ReportsSearchRequest;
use App\Models\Place;
use App\Models\Report;
use App\Models\Station;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ReportRepository as Repository;

class ReportRepository extends Repository
{
    public $message, $max_reports_to_view;

    public function __construct()
    {
        parent::__construct();
        $this->message = null;
        $this->max_reports_to_view = config('partner.last_reports_to_view', 100) + 1;
    }

    public function getReportsFromQuery(ReportsSearchRequest $request, $withPlaces = true, $isPaginator = true)
    {
        $last_reports_to_view = config('partner.last_reports_to_view', 100);
        $reports_to_page = config('partner.reports_to_page', 20);
        if ($request->hasAny(['sum_report', 'number_report', 'stations', 'data-range'])) {
            $query = Report::query();
            // ---- підготовка масиву умов відбору and --------
            $conditionsAnd = [];
            if ($request->has('interval')) {
                $this->dateStart = Carbon::createFromFormat('d/m/Y', $request->get('dateStart'));
                $this->dateFinish = Carbon::createFromFormat('d/m/Y', $request->get('dateFinish'));
                $conditionsAnd[] = ['date_flight', '>=', $this->dateStart];
                $conditionsAnd[] = ['date_flight', '<=', $this->dateFinish];
            }
            if ($request->number_report) {
                $conditionsAnd[] = ['num_report', '=', $request->number_report];
                $this->numberReport = $request->number_report;
            }
            if ($request->sum_report) {
                $conditionsAnd[] = ['sum_tariff', '=', $request->sum_report];
                $this->sum_report = $request->sum_report;
            }
            if ($request->session()->has('atpId') && session('atpId') != 0) {
                $conditionsAnd[] = ['user_id', '=', session('atpId')];
            }

            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('stations')) {
                $query->whereIn('station_id', $request->get('stations'));
                $this->stationsSelected = Station::whereIn('id', $request->get('stations'))->get();
            }
        } else {
            $query = Report::query();
            if ($request->session()->has('atpId') && session('atpId') != 0) {
                $query->where('user_id', '=', session('atpId'));
            }
        }

        $this->countReports = $query->count();

        if (!$this->countControl()) {
            if (!$isPaginator) {
                $reports = $query->orderBy('date_flight')
                    ->with('station')
                    ->take($last_reports_to_view + 1)
                    ->get();
                return $reports;
            }
            $lastReport = $query->orderBy('date_flight')
                ->skip($last_reports_to_view + 1)
                ->take(1)
                ->get();
            if ($lastReport->count() == 1) {
                $lastReportID = $lastReport[0]->id;
                $query->where('id', '<', $lastReportID);
            }
        }else{
            $query->orderBy('date_flight');
        }

        if ($withPlaces) {
            $query->withCount('places')
                ->with('station')
                ->with('places');
        } else {
            $query->with('station');
        }

        $reports = $query
            ->paginate($reports_to_page)
            ->withQueryString();

        return $reports;
    }

    public function getUsersToSelect()
    {
        $users = User::where('user_type', '=', 1)
            ->pluck('id', 'short_name');
        $users->prepend(0, 'не вказано');
        return $users;
    }

    public function countControl()
    {
        $this->message = "Увага! По запиту знайдено  {$this->countReports}. ";
        if ($this->countReports >= $this->max_reports_to_view) {
            $this->message = "Увага! По запиту знайдено значну кількість відомостей.
            Для перегляду буде видано тільки <b>{$this->max_reports_to_view}</b>. Уточніть будь ласка запит.";
            return false;
        } else {
            $this->message = null;
            return true;
        }
    }
}