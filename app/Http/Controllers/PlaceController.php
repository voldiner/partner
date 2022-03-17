<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacesSearchRequest;
use App\Repositories\PlaceRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PlaceController extends Controller
{
    public function index(PlacesSearchRequest $request, PlaceRepository $placeRepository)
    {

        $stationsFromSelect = $placeRepository->getStationsForSelect();


        $places = $placeRepository->getPlacesFromQuery($request);
        //dd($places);
        if (count($places) >= $placeRepository->places_to_view){
            Session::flash('status', "Увага! По запиту знайдено значну кількість квитків. 
            Для перегляду буде видано тільки {$placeRepository->places_to_view}. Уточніть будь ласка запит.");
        }else{
            Session::forget('status');
        }

        dump(count($places));
        //dump($request->getQueryString());
        $stationsSelected = $placeRepository->stationsSelected;
        $dateStart = $placeRepository->dateStart;
        $dateFinish = $placeRepository->dateFinish;
        $countPlaces = $placeRepository->countPlaces;
        $numberPlace = $placeRepository->numberPlace;
        $final = $placeRepository->final;
        $surname = $placeRepository->surname;
        $is_surname = $placeRepository->is_surname;
        $is_number = $placeRepository->is_number;

        $maxDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $startDateDefault = Carbon::createFromTimestamp(time())->subDay(30)->format('d/m/Y');
        $endDateDefault = Carbon::createFromTimestamp(time())->format('d/m/Y');


        return view('places', compact
        (
            'maxDate',
            'startDateDefault',
            'endDateDefault',
            'stationsFromSelect',
            'stationsSelected',
            'dateStart',
            'dateFinish',
            'countPlaces',
            'numberPlace',
            'final',
            'surname',
            'is_surname',
            'is_number',
            'places'
        ));
    }

}
