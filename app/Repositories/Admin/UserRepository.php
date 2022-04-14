<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11.04.2022
 * Time: 10:54
 */

namespace App\Repositories\Admin;


use Illuminate\Validation\Rule;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        if ($request->has(['parameter', 'signature']) && (!is_null($request->get('signature')))) {
            // --- скасувати відбір по назві перевізника
            session(['atpId' => 0]);
            session()->forget('atpName');
            $this->paramSelected = $request->get('parameter');
            $this->signature = $request->get('signature');
            $query = User::query();

            if ($request->get('parameter') === 'kod_fxp' ) {
                $this->signature = $request->get('signature');
                $conditionsAnd[] = ['kod_fxp', '=', $request->get('signature')];
            }else{
                $conditionsAnd[] = [$request->get('parameter'), 'like', '%' . $request->get('signature') . '%'];
            }

            if ($request->session()->has('atpId') && session('atpId') != 0){
                $conditionsAnd[] = ['id', '=', session('atpId')];
            }

            $query->where($conditionsAnd);

        } else {

            $query = User::query();
            if ($request->session()->has('atpId') && session('atpId') != 0){
                $query->where('id', '=', session('atpId'));
            }
        }
        //dd($query->get());
        $this->countUsers = $query->count();

        $users = $query
            // ->orderBy('date_flight')
            ->paginate($users_to_page)
            ->withQueryString();

        return $users;

    }

    public function getParametersForSelect()
    {
        $result = config('partner.users_parameters_to_find', []);

        return $result;
    }

    public function validateUserSearchRequest(Request $request)
    {
        $values =  array_keys(config('partner.users_parameters_to_find',[]));
        $validator = Validator::make($request->all(), [
            'parameter' => [
                Rule::in($values),
            ]
        ]);
        $validator->sometimes('signature', 'required|integer', function ($input) {
            return $input->parameter === 'kod_fxp';
        });
        $validator->sometimes('signature', 'required|string|max:40', function ($input) {
            return $input->parameter === 'email';
        });
        $validator->sometimes('signature', 'required|numeric', function ($input) {
            return $input->parameter === 'identifier';
        });
        $validator->sometimes('signature', 'required|numeric', function ($input) {
            return $input->parameter === 'certificate';
        });
        $validator->sometimes('signature', 'required|numeric', function ($input) {
            return $input->parameter === 'certificate_tax';
        });
        $validator->sometimes('signature', 'required|numeric', function ($input) {
            return $input->parameter === 'edrpou';
        });

        return $validator;
    }

    public function getCountMessage($count)
    {
        $count = intval($count);
        $result = 'перевізників';
        if ($count > 4 && $count<20){
            return 'перевізників';
        }

        $stringCount = substr(strval($count), -1);
        if ($stringCount === '4' || $stringCount === '3' || $stringCount === '2'){
            $result = 'перевізника';
        }elseif ($stringCount === '1'){
            $result = 'перевізник';
        }else {
            $result = 'перевізників';
        }

        return $result;

    }
}