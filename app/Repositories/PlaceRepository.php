<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.03.2022
 * Time: 9:56
 */

namespace App\Repositories;

use App\Models\Place;
use App\Models\Report;
use Carbon\Carbon;
use App\Http\Requests\PlacesSearchRequest;
use App\Models\Station;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PlaceRepository
{
    public $stationsSelected, $dateStart, $dateFinish, $countPlaces, $numberPlace, $final, $surname, $places_to_view, $is_surname, $is_number;
    protected $result;
    public function __construct()
    {
        $this->stationsSelected = null;
        $this->dateStart = null;
        $this->dateFinish = null;
        $this->countPlaces = 0;
        $this->numberPlace = null;
        $this->final = null;
        $this->surname = null;
        $this->places_to_view = config('partner.places_to_view');
        $this->result = [];
        $this->is_surname = false;
        $this->is_number = false;
    }

    public function getStationsForSelect()
    {
        $result = Station::all()->pluck('name', 'id');
        return $result;
    }

    public function getPlacesFromQuery(PlacesSearchRequest $request)
    {
        $places_to_page = config('partner.places_to_page');
        $this->numberPlace = !empty($request->number_place) ? $request->number_place : null;
        $this->final = !empty($request->final) ? str_replace(['і','І'], ['i', 'I'], $request->final) : null;
        $this->surname = !empty($request->surname) ? str_replace(['і','І'], ['i', 'I'], $request->surname) : null;

        if ($request->hasAny(['stations', 'data-range']) || $this->numberPlace || $this->final || $this->surname  ) {

            if (\Str::contains($this->surname, ['1','2','3','4','5','6','7','8','9'])){
                $this->is_number = true;
            }else{
                $this->is_surname = true;
            }
            $query = Report::query();
            $query->select('name_flight', 'time_flight', 'date_flight', 'user_id', 'station_id', 'id');
            // ---- підготовка масиву умов відбору Reports --------
            $conditionsAnd = [];
            if ($request->has('interval')) {
                $this->dateStart = Carbon::createFromFormat('d/m/Y', $request->get('dateStart'));
                $this->dateFinish = Carbon::createFromFormat('d/m/Y', $request->get('dateFinish'));
                $conditionsAnd[] = ['date_flight', '>=', $this->dateStart];
                $conditionsAnd[] = ['date_flight', '<=', $this->dateFinish];
            }
            $conditionsAnd[] = ['user_id', '=', auth()->user()->id];
            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('stations')) {
                $query->whereIn('station_id', $request->get('stations'));
                $this->stationsSelected = Station::whereIn('id', $request->get('stations'))->get();
            }

            $key = (crc32(serialize($request->except('page'))));
            if (Cache::has($key)){
                dump('get from cache');
                $this->result = Cache::get($key);
                $this->countPlaces = count($this->result);
                return $this->result;
            }

            $query->chunk(50, function ($reports) {
                foreach ($reports as $report) {
                    $conditionsAndPlaces = [];
                    // ----  place ------
                    if ($this->numberPlace) {
                        $conditionsAndPlaces[] = ['ticket_id', 'like', '%' . $this->numberPlace . '%'];
                    }
                    if ($this->final) {
                        $conditionsAndPlaces[] = ['name_stop', 'like', '%' . $this->final . '%'];
                    }
                    if ($this->surname) {
                        if ($this->is_surname){
                            $conditionsAndPlaces[] = ['name_passenger', 'like', '%' . $this->surname . '%'];
                        }
                        if ($this->is_number){
                            $conditionsAndPlaces[] = ['num_certificate', 'like', '%' . $this->surname . '%'];
                        }
                    }
                    if ($conditionsAndPlaces) {
                        $places = $report->places()->where($conditionsAndPlaces)->get();
                    }else{
                        $places = $report->places;
                    }
                    if ($places) {
                        foreach ($places as $place) {
                            $this->result[] = [
                                'start' => $report->station->name,
                                'name_flight' => $report->name_flight,
                                'time_flight' => $report->time_flight,
                                'date_flight' => $report->date_flight,
                                'ticket_id' => $place->ticket_id,
                                'number_place' => $place->number_place,
                                'name_stop' => $place->name_stop,
                                'sum' => $place->sum,
                                'num_certificate' => $place->num_certificate,
                                'name_benefit' => $place->name_benefit,
                                'name_passenger' => $place->name_passenger,
                        ];
                            $this->countPlaces ++;
                            if ($this->countPlaces >= $this->places_to_view){
                                return;
                            }
                        }


                    }

                }
            });
            Cache::put($key, $this->result, 60 * 60 );
        }


        return $this->result;
    }
}