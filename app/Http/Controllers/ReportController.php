<?php

namespace App\Http\Controllers;

use App\Mail\WarningCreateReportMail;
use App\Models\Place;
use App\Models\Report;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;

class ReportController extends Controller
{
    private $warnings = [];

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * http://partner:81/reports/create?fileReports=reports1.dbf&filePlaces=places1.dbf
     */
    public function createReports(Request $request)
    {
        if (!$request->has('fileReports')) {
            Log::channel('download_reports')->debug('get parameter fileReports  not exist');
            return response()->json(['error' => 'get parameter fileReports  not exist'], 404);
        }
        if (!$request->has('filePlaces')) {
            Log::channel('download_reports')->debug('get parameter filePlaces  not exist');
            return response()->json(['error' => 'get parameter filePlaces  not exist'], 404);
        }
        //todo добавити транзакцію
        $nameReportfile = 'downloads/' . $request->get('fileReports');
        $namePlacesfile = 'downloads/' . $request->get('filePlaces');

        if (Storage::missing($nameReportfile)) {
            Log::channel('download_reports')->debug($nameReportfile . ' not exist');
            return response()->json(['error' => $nameReportfile . ' not exist'], 404);
        }
        if (Storage::missing($namePlacesfile)) {
            Log::channel('download_reports')->debug($namePlacesfile . ' not exist');
            return response()->json(['error' => $namePlacesfile . ' not exist'], 404);
        }

        try {
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
            $station = null;
            // ----- підготовка списку ас ------ //
            $stations = Station::all();
            // ----- підготовка списку перевізників ----- //
            $users = User::where('user_type', 1)
                ->select(['id', 'name', 'kod_fxp'])
                ->get()
                ->toBase();

            while ($record = $table->nextRecord()) {
                $countReportsAll++;
                // ------ валідація -------- //
                if (!$this->validateRecord($record, $stations, $users)) {
                    continue;
                }
                $user_id = $this->getUserId($users, $record);
                if (!$station) {
                    $station = $this->getStation($stations, $record);
                }

                if ($user_id === 0) {
                    continue;
                }
                if (!$station) {
                    continue;
                }
                $places = $this->getPlacesFromDBF($record->get('kr'), $record->get('vr'), $record->get('nved'), $tablePlaces);
                if (!$places) {
                    continue;
                }
                // ----- визначим додавати нову відомість чи коректувати стару ------- //
                $report = Report::where([
                    ['kod_flight', '=', $record->get('kr')],
                    ['time_flight', '=', $record->get('vr')],
                    ['day', '=', $record->get('day')],
                    ['month', '=', $record->get('month')],
                    ['year', '=', $record->get('year')],
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
            Log::channel('download_reports')->debug("Add {$countReportsAdd} reports. Update {$countReportsUpdate} reports. Time {$timeWork} sec.");
            $toResponce = ['success' => "Processed {$countReportsAll} record. Add {$countReportsAdd} reports. Update {$countReportsUpdate} reports. Time {$timeWork} sec."];
            if (count($this->warnings)) {
                Mail::send(new WarningCreateReportMail($this->warnings, $station->name));
                foreach ($this->warnings as $warning) {
                    Log::channel('download_reports')->debug($warning);
                }
                $toResponce['warnings'] = $this->warnings;
            }
            $nameReportArchive = 'reports/' . date("Y_m_d_H_i_s_") . $request->get('fileReports');
            $namePlacesArchive = 'reports/' . date("Y_m_d_H_i_s_") . $request->get('filePlaces');
            $this->moveToArchive($nameReportfile, $namePlacesfile, $nameReportArchive, $namePlacesArchive);
            return response()->json($toResponce, 200);

        } catch (\Exception $e) {
            Log::channel('download_reports')->debug($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * @param string $kod_ac
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
     * @param $kod_atp
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
            $this->warnings[] = " Error not found user_id " . $record->get('katp') . " report #" . $record->get('nved');
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

    protected function getPlacesFromDBF($kod_flight, $time_flight, $nomved, $table)
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
                    'name_benefit' => $record->get('name_plg'),
                    'name_passenger' => $record->get('fml_plg'),
                    'type' => $record->get('internet'),
                ]);
            }
        }
        if (count($result) === 0) {
            $this->warnings[] = " Error not found places report #{$nomved}";
            dump(" Error not found places report #{$nomved}");
            return false;
        }
        return $result;
    }

    protected function validateRecord($record)
    {
        $result = true;
        if (!is_numeric($record->get('katp')) || $record->get('katp') == 0) {
            $this->warnings[] = " Error validate katp " . $record->get('katp') . " report #" . $record->get('nved');
            $result = false;
            dump("Error validate katp " . $record->get('katp') . " report #" . $record->get('nved'));
        }
        if (!is_numeric($record->get('kod_ac')) || $record->get('kod_ac') == 0) {
            $result = false;
            $this->warnings[] = " Error validate kod_ac " . $record->get('kod_ac') . " report #" . $record->get('nved');
            dump("Error validate kod_ac " . $record->get('kod_ac') . " report #" . $record->get('nved'));
        }
        if ($record->get('vr') <= 0 || $record->get('vr') > 24.00) {
            $result = false;
            $this->warnings[] = "Error validate vr " . $record->get('vr') . " report #" . $record->get('nved');
            dump("Error validate vr " . $record->get('vr') . " report #" . $record->get('nved'));
        }
        if (empty($record->get('name_r'))) {
            $result = false;
            $this->warnings[] = "Error validate name_r report #" . $record->get('nved');
            dump("Error validate name_r report #" . $record->get('nved'));
        }
        if (!$this->validateDMY($record->get('day'), $record->get('month'), $record->get('year'))) {
            $result = false;
            $this->warnings[] = "Error validate day, month, year  report #" . $record->get('nved');
            dump("Error validate day, month, year  report #" . $record->get('nved'));
        }
        return $result;
    }

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

    public function moveToArchive($nameReportfile, $namePlacesfile, $nameReportArchive, $namePlacesArchive)
    {
        try {
            throw new \Exception('Testing exception!!!');
            Storage::move($nameReportfile, $nameReportArchive);
            Storage::move($namePlacesfile, $namePlacesArchive);
        } catch (\Exception $e) {
            Log::channel('download_reports')->debug($e->getMessage());
        }

    }


}
