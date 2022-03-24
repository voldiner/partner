<?php

namespace App\Http\Controllers;

use App\Repositories\IndexRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index( IndexRepository $indexRepository)
    {
        $reports = $indexRepository->getLastReports();
        $statistic = $indexRepository->getStatistic();

        return view('dashboard', compact(
            'reports',
            'statistic'

        ));
    }
}
