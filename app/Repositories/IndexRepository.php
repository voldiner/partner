<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 23.03.2022
 * Time: 12:55
 */

namespace App\Repositories;


use App\Models\Report;

class IndexRepository
{
    public $last_reports_to_view, $last_places_to_view;
    public function __construct()
    {
        $this->last_reports_to_view = 10;
        $this->last_places_to_view = 10;

    }

    public function getLastReports()
    {

        $reports = Report::
        select(['id', 'num_report', 'name_flight', 'time_flight', 'sum_tariff', 'date_flight', 'station_id'])
            ->where('user_id', '=', auth()->user()->id)
            ->withCount('places')
            ->orderBy('id', 'desc')
            ->with('places')
            ->with('station')
            ->take($this->last_reports_to_view)
            ->get();

        return $reports;

    }

    public function getLastPlaces()
    {


    }

}