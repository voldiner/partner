<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11.04.2022
 * Time: 10:54
 */

namespace App\Repositories\Admin;


use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
     protected $monthsFromSelect;
         public $countUsers, $paramSelected, $signature;

    public function __construct()
    {
        $this->monthsFromSelect = [
            1 => 'січень',
            2 => 'лютий',
            3 => 'березень',
            4 => 'квітень',
            5 => 'травень',
            6 => 'червень',
            7 => 'липень',
            8 => 'серпень',
            9 => 'вересень',
            10 => 'жовтень',
            11 => 'листопад',
            12 => 'грудень',
        ];
        $this->countUsers = 0;
        $this->paramSelected = null;
        $this->signature = null;
    }

    public function getStatistic()
    {
        $result = [];

        $result['allUsers'] = User::where('user_type', '=', 1)->count();
        $result['registeredUsers']['count'] = User::whereNotNull('email')->whereNotNull('password')->count();
        $result['registeredUsers']['percent'] = $result['allUsers'] > 0 ? 100 * $result['registeredUsers']['count'] / $result['allUsers'] : 0;
        $result['confirmEmailUsers']['count'] = User::whereNotNull('email_verified_at')->count();
        $result['confirmEmailUsers']['percent'] = $result['allUsers'] > 0 ? 100 * $result['confirmEmailUsers']['count'] / $result['allUsers'] : 0;

        $dateLastInvoice = Invoice::orderByRaw('year * 10000 + month DESC')->first();

        if ($dateLastInvoice){
            $result['dateLastInvoice']['month'] = $this->monthsFromSelect[$dateLastInvoice->month];
            $result['dateLastInvoice']['year'] = $dateLastInvoice->year;
        }

        return $result;
    }

    public function getUsersToSelect()
    {
        $users = User::where('user_type', '=', 1)
            ->pluck('id','short_name');
        $users->prepend(0,'не вказано' );
        return $users;
    }

    public function getUsersFromQuery(Request $request)
    {
        $users_to_page = config('partner.users_to_page');

        if ($request->hasAny(['months', 'year'])) {

            $query = Invoice::query();
            // ---- підготовка масиву умов відбору and --------
            $conditionsAnd = [];
            if ($request->has('year') && (!is_null($request->get('year')))) {
                $this->year = $request->get('year');
                $conditionsAnd[] = ['year', '=', $request->get('year')];
            }

            if ($request->session()->has('atpId') && session('atpId') != 0){
                $conditionsAnd[] = ['user_id', '=', session('atpId')];
            }

            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('months')) {
                foreach ($this->monthsFromSelect as $key => $month){
                    if (in_array($key, $request->get('months') ) ){
                        $this->monthsSelected[$key] = $month;
                    }
                }
                $query->whereIn('month', $request->get('months'));
            }
        } else {

            $query = Invoice::query();
            if ($request->session()->has('atpId') && session('atpId') != 0){
                $query->where('id', '=', session('atpId'));
            }
        }

        $this->countUsers = $query->count();

        $users = $query
            // ->orderBy('date_flight')
            ->paginate($users_to_page)
            ->withQueryString();

        return $users;

    }

    public function getParametersForSelect()
    {
        $result = config('partner.users_parameters_to_find');

        return $result;
    }
}