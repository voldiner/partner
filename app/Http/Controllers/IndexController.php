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

    public function welcome()
    {

        return view('welcome');
    }

    public function termsOfUse()
    {
        return view('about');
    }

    public function privacyPolicy()
    {
        return view('privacypolicy');
    }
//    public function welcome401()
//    {
//        return view('errors.401');
//    }
}
