<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {

        //$reports = $indexRepository->getLastReports();
        //$statistic = $indexRepository->getStatistic();
        $users = User::where('user_type', '=', 1)->pluck('id','short_name');
        $users->put('не вказано', 0);
        return view('admin.dashboard', compact(
         'users'
        ));
    }

    public function setCarrier(Request $request)
    {

        $request->validate([
            'atp' => 'required|integer',
        ]);
        // --- показати всіх перевізників --- //
        if ($request->atp == 0){
            session(['atpId' => $request->atp]);
            session()->forget('atpName');
            return back();
        }

        $atp = User::find($request->atp);

        if (!$atp){
            return back()->with('error', "Помилка - перевізник з кодом {$request->atp} не знайдено");
        }

        session(['atpId' => $atp->id]);
        session(['atpName' => $atp->full_name]);

        return back();
    }
}
