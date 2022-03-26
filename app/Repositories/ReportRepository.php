<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2022
 * Time: 19:34
 */

namespace App\Repositories;


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

class ReportRepository
{
    public $warnings;
    public $numberReport, $sum_report, $stationsSelected, $dateStart, $dateFinish, $countReports;
    public $total, $countedStops;
    public function __construct()
    {
        $this->warnings = [];
        $this->numberReport = null;
        $this->sum_report = null;
        $this->stationsSelected = null;
        $this->dateStart = null;
        $this->dateFinish = null;
        $this->countReports = null;
        $this->total = [];
        $this->countedStops = null;
    }

    /**
     * create Reports and relations Places from dbf files
     * @param string $nameReportfile
     * @param string $namePlacesfile
     * @return string
     * @throws \Exception
     */
    public function createReports($nameReportfile, $namePlacesfile)
    {
        $table = new TableReader(
            storage_path('app/' . $nameReportfile),
            [
                'encoding' => 'cp866'
            ]
        );
        $tablePlaces = new TableReader(
            storage_path('app/' . $namePlacesfile),
            [
                'encoding' => 'cp866'
            ]
        );

        //throw new \Exception('Testing exception!!!');
        $countReportsAdd = 0;
        $countReportsUpdate = 0;
        $countReportsAll = 0;
        $startTime = time();

        $stations = Station::all();

        $users = User::where('user_type', 1)
            ->select(['id', 'name', 'kod_fxp'])
            ->get()
            ->toBase();

        while ($record = $table->nextRecord()) {

            $countReportsAll++;
            // ------ валідація -------- //
            if (!$this->validateRecord($record)) {
                continue;
            }
            $user_id = $this->getUserId($users, $record);

            $station = $this->getStation($stations, $record);


            if ($user_id === 0) {
                continue;
            }
            if (!$station) {
                continue;
            }
            $places = $this->getPlacesFromDBF($record->get('kr'), $record->get('vr'), $record->get('nved'), $tablePlaces, $record->get('kod_ac'));
            if (!$places) {
                continue;
            }
            // ----- визначим додавати нову відомість чи коректувати стару ------- //
            // todo добавити умову по автостанції (добавив перевірити як працює) якщо відомість видалена на АС
            // todo то як при синхронізації це відобразхити
            $report = Report::where([
                ['kod_flight', '=', $record->get('kr')],
                ['time_flight', '=', $record->get('vr')],
                ['day', '=', $record->get('day')],
                ['month', '=', $record->get('month')],
                ['year', '=', $record->get('year')],
                ['kod_ac', '=', $record->get('kod_ac')]
            ])->first();

            if ($report) {
                // видалити  places ,оновити report
                $report->places()->delete();
                $countReportsUpdate++;
            } else {
                $report = new Report();
                $countReportsAdd++;
            }

            $this->fillReport($report, $record, $station, $user_id);

            $report->save();

            $report->places()->saveMany($places);
        }
        $timeWork = time() - $startTime;
        $result = "Processed {$countReportsAll} record. Add {$countReportsAdd} reports. Update {$countReportsUpdate} reports. Time {$timeWork} sec.";
        return $result;

    }

    /**
     * @param XBase\Record\DBaseRecord $record
     * @param Collection $stations
     * @return Model | null
     */
    protected function getStation(Collection $stations, $record)
    {
        $station = $stations->firstWhere('kod', '=', $record->get('kod_ac'));
        if (!$station) {
            $this->warnings[] = "Error not found station_id " . $record->get('kod_ac') . " report #" . $record->get('nved');
            dump("Error not found station_id " . $record->get('kod_ac') . " report #" . $record->get('nved'));
        }
        return $station;
    }


    /**
     * @param XBase\Record\DBaseRecord $record
     * @param Collection $users
     * @return int
     */
    protected function getUserId($users, $record)
    {
        $user = $users->firstWhere('kod_fxp', '=', $record->get('katp'));
        if ($user) {
            $result = $user->id;
        } else {
            $result = 0;
            $this->warnings[] = 'Error not found user_id ' . $record->get('katp') . ' report #' . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            dump(" Error not found user_id " . $record->get('katp') . " report #" . $record->get('nved'));
        }
        return $result;
    }

    /**
     * валідація дня місяця року
     * @param int $day
     * @param int $month
     * @param int $year
     * @return bool
     */
    protected function validateDMY($day, $month, $year)
    {
        $resultDay = true;
        $resultMonth = true;
        $resultYear = true;
        if ($day <= 0 || $day > 31) {
            $resultDay = false;
        }
        if ($month <= 0 || $month > 12) {
            $resultMonth = false;
        }
        if ($year < 2000 || $year > 2100) {
            $resultYear = false;
        }
        if ($resultDay && $resultMonth && $resultYear) {
            return true;
        }
        return false;
    }

    protected function getPlacesFromDBF($kod_flight, $time_flight, $nomved, $table, $kod_ac)
    {
        $result = [];
        $table->moveTo(0);
        while ($record = $table->nextRecord()) {
            if ($kod_flight === $record->get('kr') && $time_flight === $record->get('vr')) {
                $result[] = new Place([
                    'ticket_id' => $record->get('ticket_id'),
                    'number_place' => $record->get('number'),
                    'kod_flight' => $record->get('kr'),
                    'time_flight' => $record->get('vr'),
                    'name_stop' => $record->get('name_stop'),
                    'sum' => $record->get('suma'),
                    'num_certificate' => $record->get('num_psw'),
                    'name_benefit' => empty($record->get('name_plg')) ? null : $record->get('name_plg'),
                    'name_passenger' => $record->get('fml_plg'),
                    'type' => $record->get('internet'),
                ]);
            }
        }
        if (count($result) === 0) {
            $this->warnings[] = " Error not found places report #{$nomved} код АС {$kod_ac} код рейсу {$kod_flight} час відправки {$time_flight}";
            dump(" Error not found places report #{$nomved}");
            return false;
        }
        return $result;
    }

    /**
     * валідація строки з dbf file
     * @param XBase\Record\DBaseRecord $record
     * @return bool
     */
    protected function validateRecord($record)
    {
        $result = true;
        if (!is_numeric($record->get('katp')) || $record->get('katp') == 0) {
            $this->warnings[] = " Error validate katp " . $record->get('katp') . " report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            $result = false;
            dump("Error validate katp " . $record->get('katp') . " report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac'));
        }
        if (!is_numeric($record->get('kod_ac')) || $record->get('kod_ac') == 0) {
            $result = false;
            $this->warnings[] = " Error validate kod_ac " . $record->get('kod_ac') . " report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            dump("Error validate kod_ac " . $record->get('kod_ac') . " report #" . $record->get('nved'));
        }
        if ($record->get('vr') <= 0 || $record->get('vr') > 24.00) {
            $result = false;
            $this->warnings[] = "Error validate vr " . $record->get('vr') . " report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            dump("Error validate vr " . $record->get('vr') . " report #" . $record->get('nved'));
        }
        if (empty($record->get('name_r'))) {
            $result = false;
            $this->warnings[] = "Error validate name_r report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            dump("Error validate name_r report #" . $record->get('nved'));
        }
        if (!$this->validateDMY($record->get('day'), $record->get('month'), $record->get('year'))) {
            $result = false;
            $this->warnings[] = "Error validate day, month, year  report #" . $record->get('nved') . ' код АС ' . $record->get('kod_ac');
            dump("Error validate day, month, year  report #" . $record->get('nved'));
        }
        return $result;
    }

    /**
     * @param Report $report
     * @param XBase\Record\DBaseRecord $record
     * @param Station $station
     * @param int $user_id
     */
    protected function fillReport($report, $record, $station, $user_id)
    {
        $report->kod_atp = $record->get('katp');
        $report->num_report = $record->get('nved');
        $report->name_flight = $record->get('name_r');
        $report->time_flight = $record->get('vr');
        $report->kod_flight = $record->get('kr');
        $report->date_flight = $record->get('year') . '-' . $record->get('month') . '-' . $record->get('day');
        $report->sum_tariff = $record->get('suma');
        $report->sum_baggage = $record->get('sumb');
        $report->sum_insurance = $record->get('zbir');
        $report->add_report = $record->get('dod_vid') == 0 ? false : true;
        $report->kod_ac = $record->get('kod_ac');
        $report->year = $record->get('year');
        $report->month = $record->get('month');
        $report->day = $record->get('day');
        $report->user_id = $user_id;
        $report->station_id = $station->id;
    }

    public function moveToArchive($nameReportfile, $namePlacesfile, $nameReportArchive, $namePlacesArchive, $loggingRepository)
    {
        $nameReportArchive = 'reports/' . date("Y_m_d_H_i_s_") . $nameReportArchive;
        $namePlacesArchive = 'reports/' . date("Y_m_d_H_i_s_") . $namePlacesArchive;
        try {
            //throw new \Exception('Testing exception!!!');
            Storage::move($nameReportfile, $nameReportArchive);
            Storage::move($namePlacesfile, $namePlacesArchive);
        } catch (\Exception $e) {
            $loggingRepository->createReportsLoggingMessage($e->getMessage());

        }
    }

    /**
     * @param string $message
     * @param array $warnings
     * @return array
     */
    public function createDataResponce(string $message, array $warnings)
    {
        $result = ['success' => $message];
        if (count($warnings)) {
            $result['warnings'] = $warnings;
        }
        return $result;
    }

    public function getStationsForSelect()
    {
        $result = Station::all()->pluck('name', 'id');
        return $result;
    }

    public function getReportsFromQuery(ReportsSearchRequest $request, $withPlaces = true, $isPaginator = true)
    {
        $last_reports_to_view = config('partner.last_reports_to_view');
        $reports_to_page = config('partner.reports_to_page');
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
            $conditionsAnd[] = ['user_id', '=', auth()->user()->id];
            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('stations')) {
                $query->whereIn('station_id', $request->get('stations'));
                $this->stationsSelected = Station::whereIn('id', $request->get('stations'))->get();
            }

        } else {
            // до 20 останніх записів
            $lastReport = Report::
                where('user_id', '=', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->skip($last_reports_to_view)
                ->take(1)
                ->get();

            if ($lastReport->count() == 1) {
                $lastReportID = $lastReport[0]->id;
                $query = Report::query()->where('id', '>', $lastReportID);
            } else {
                $query = Report::query();
            }
            $query->where('user_id', '=', auth()->user()->id);
        }

        $this->countReports = $query->count();

        if ($withPlaces) {
            $reports = $query->withCount('places')
                ->orderBy('date_flight')
                ->with('station')
                ->with('places');

        } else {
            $reports = $query->orderBy('date_flight')
                ->with('station');
        }
        if ($isPaginator) {
            $reports = $query
                ->paginate($reports_to_page)
                ->withQueryString();
        } else {
            $reports = $query->get();
        }

        return $reports;

    }

    public function getPlacesForCreateReportPdf(Report $report)
    {
        $places = $report->places;

        $this->total['countAll'] = $places->count();
        $this->total['sumAll'] = $places->sum(function ($place) {
            return $place->sum;
        });

        $this->total['sum50'] = $places
            ->where('sum_tariff', '>', 0)
            ->where('name_benefit')
            ->sum(function ($place) {
                return $place->sum;
            });
        $this->total['count50'] = $places
            ->where('sum_tariff', '>', 0)
            ->where('name_benefit')
            ->count();
        $this->total['sum0'] = $places
            ->where('sum_tariff', '=', 0)
            ->where('name_benefit')
            ->sum(function ($place) {
                return $place->sum;
            });
        $this->total['count0'] = $places
            ->where('sum_tariff', '=', 0)
            ->where('name_benefit')
            ->count();

        $this->countedStops = $places->countBy('name_stop');

        return $places;
    }

    public function statistic()
    {
        $statisticRepository = new StatisticRepository();

        $result = $statisticRepository->countStatistic();

        return $result;
    }
}