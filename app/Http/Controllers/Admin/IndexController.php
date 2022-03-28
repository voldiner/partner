<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {

        //$reports = $indexRepository->getLastReports();
        //$statistic = $indexRepository->getStatistic();

        return view('admin.dashboard'



        );
    }
}
