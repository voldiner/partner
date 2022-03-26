<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24.03.2022
 * Time: 10:12
 */

namespace App\Repositories;



use App\Models\Report;
use App\Models\User;

class StatisticRepository
{
    protected $result;

    public function __construct()
    {
        $this->result = [];
    }

    /**
     * dateInfo -  Інформація з відомостей станом на
     * numberReportsAll - всього завантажено відомостей
     * numberPlacesAll - всього завантажено квитків
     * numberPlacesBenefit  т.ч. пільгові квитки
     * @param int $id
     * @return array
     */
    public function getStatistic($id)
    {
        $user = User::find($id);

        if (is_null($user) || is_null($user->statistic)) {
            return [];
        }
        $result = $user->statistic;
        return $result;
    }

    /**
     * обрахунок статистичної інформації по перевізнику
     * @param int $id
     * @return string
     */
    public function countStatistic()
    {
        $timeStart = time();
        User::query()
            ->select(['id', 'user_type', 'statistic'])
            ->where('user_type', '=', 1)
            ->chunk(50, function ($users) {
                foreach ($users as $user){
                    //dump($user->id . '->' . $this->countStatistibById($user->id)['numberReportsAll']);
                    $user->statistic = $this->countStatistibById($user->id);
                    $user->save();
                }
            });
        $timeWork = time() - $timeStart;
        $message = "Statistic count success. Time work {$timeWork} sec.";
        return $message;

    }

    private function countStatistibById($id)
    {
        $this->result = [];
        $report = Report::where('user_id', '=', $id)
            ->orderBy('date_flight', 'desc')
            ->first();
        if ($report) {
            $this->result['dateInfo'] = $report->date_flight->format('d-m-Y');
        }
        // ------
        $this->result['numberReportsAll'] = Report::where('user_id', '=', $id)->count();

        // -------
        if ($this->result['numberReportsAll'] > 0){
            $this->result['numberPlacesAll'] = 0;
            $this->result['numberPlacesBenefit'] = 0;
            Report::select(['id','user_id'])
                ->where('user_id', '=', $id)
                ->chunk(50, function ($reports) {
                    foreach ($reports as $report){
                        $this->result['numberPlacesAll'] += $report->places()->count();
                        $this->result['numberPlacesBenefit'] += $report->places()->whereNotNull('name_benefit')->count();
                    }

                });
        }

        return $this->result;
    }
}