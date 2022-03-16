<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacesSearchRequest;
use App\Repositories\PlaceRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlaceController extends Controller
{
    public function index(PlacesSearchRequest $request, PlaceRepository $placeRepository)
    {

        $stationsFromSelect = $placeRepository->getStationsForSelect();


        $places = $placeRepository->getPlacesFromQuery($request);

        dump($places);

        $stationsSelected = $placeRepository->stationsSelected;
        $dateStart = $placeRepository->dateStart;
        $dateFinish = $placeRepository->dateFinish;
        $countPlaces = $placeRepository->countPlaces;
        $numberPlace = $placeRepository->numberPlace;
        $final = $placeRepository->final;
        $surname = $placeRepository->surname;

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
            'surname'

        ));
    }

}
