<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        $users = User::where('user_type', '=', 1)->pluck('id', 'short_name');
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
        if ($request->atp == 0) {
            session(['atpId' => $request->atp]);
            session()->forget('atpName');
            return back();
        }

        $atp = User::find($request->atp);

        if (!$atp) {
            return back()->with('error', "Помилка - перевізник з кодом {$request->atp} не знайдено");
        }

        session(['atpId' => $atp->id]);
        session(['atpName' => $atp->full_name]);

        return back();
    }

    public function readLogs(Request $request)
    {
        $users = User::where('user_type', '=', 1)->pluck('id', 'short_name');
        $users->put('не вказано', 0);
        $log = [];
        $nameLog = '';
        //dd($request->get('date-day'));
        if ($request->has(['date-day', 'nameLog'])) {
            $fileName = storage_path('logs/' . $request->get('nameLog'));
            if (file_exists($fileName)) {
                $logAll = file($fileName);
            }else{
                return redirect()->route('manager.logs')->with(['error' => 'File ' . $request->get('nameLog') . ' not found!']);
            }
            //  відбір по даті 2022-05-04 треба   29/05/2022 - є
            $dateSelection = $this->createDate($request->get('date-day'));
            //dd($dateSelection);
            foreach ($logAll as $line) {
                if (str_contains($line, $dateSelection)) {
                    $log[] = $line;
                }
            }

            $startDate = Carbon::createFromFormat('d/m/Y' ,$request->get('date-day'))->format('d/m/Y');
            $nameLog = $request->get('nameLog');
        }
        $maxDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        $endDate = Carbon::createFromTimestamp(time())->subDays(2)->format('d/m/Y');
        if (!isset($startDate)){
            $startDate = Carbon::createFromTimestamp(time())->format('d/m/Y');
        }

        return view('admin.logs', compact(
            'users',
            'log',
            'maxDate',
            'endDate',
            'startDate',
            'nameLog'
        ));
    }

    protected function createDate($requestDate)
    {
        return substr($requestDate, 6, 4) . '-' . substr($requestDate, 3, 2) . '-' . substr($requestDate, 0, 2);
    }

}
