<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;


class UserController extends Controller
{
    public function index( Request $request, UserRepository $userRepository)
    {
        $validator = $userRepository->validateUserSearchRequest($request);

        if ($validator->fails()) {
           return back()->withErrors($validator)->withInput();
        }

        $usersForList = $userRepository->getUsersFromQuery($request);

        $statistic = $userRepository->getStatistic();
        $users = $userRepository->getUsersToSelect();
        $parametersForSelect = $userRepository->getParametersForSelect();
        $paramSelected = $userRepository->paramSelected;
        $signature = $userRepository->signature;
        $countUsers = $userRepository->countUsers;
        $countMessage = $userRepository->getCountMessage($countUsers);
        return view('admin.dashboard', compact(
            'users',
            'statistic',
            'usersForList',
            'parametersForSelect',
            'paramSelected',
            'signature',
            'countUsers',
            'countMessage'
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
        //dd(url()->previous());
        if ($request->has('carrier')){
            return redirect(route('manager.index'));
        }
        return back();
    }
}
