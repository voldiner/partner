<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.03.2022
 * Time: 9:41
 */

namespace App\Repositories\Admin;


use App\Http\Requests\InvoicesSearchRequest;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Retention;
use XBase\TableReader;
use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use \App\Repositories\InvoiceRepository as Repository;

class InvoiceRepository extends Repository
{
    public $warnings, $countInvoices;
    protected $stations;
    public $monthsSelected, $monthsFromSelect, $year;

    public function __construct()
    {
        $this->warnings = [];
        $this->stations = Station::all();
        $this->countInvoices = 0;
        $this->monthsSelected = [];
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
        $this->year = null;
    }


    public function getInvoicesFromQuery(InvoicesSearchRequest $request)
    {

        $last_invoices_to_view = config('partner.last_invoices_to_view');
        $invoices_to_page = config('partner.invoices_to_page');

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
            // до 20 останніх записів
            $lastInvoice = Invoice::
            where('user_id', '=', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->skip($last_invoices_to_view)
                ->take(1)
                ->get();

            if ($lastInvoice->count() == 1) {
                $lastInvoiceID = $lastInvoice[0]->id;
                $query = Invoice::query()->where('id', '>', $lastInvoiceID);
            } else {
                $query = Invoice::query();
            }
            if ($request->session()->has('atpId') && session('atpId') != 0){
                $query->where('user_id', '=', session('atpId'));
            }

        }

        $this->countInvoices = $query->count();


        $invoices = $query
            // ->orderBy('date_flight')
            ->with('products')
            ->with('retentions')
            ->paginate($invoices_to_page)
            ->withQueryString();

        return $invoices;
    }

    public function getUsersToSelect()
    {
        $users = User::where('user_type', '=', 1)
            ->pluck('id','short_name');
        $users->prepend(0,'не вказано' );
        return $users;
    }
}