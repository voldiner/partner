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
use Illuminate\Support\Facades\Http;
use XBase\TableReader;
use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use \App\Repositories\InvoiceRepository as Repository;

class InvoiceRepository extends Repository
{
    public $warnings, $countInvoices;
    protected $stations, $max_invoices_to_view;
    public $monthsSelected, $monthsFromSelect, $year, $message;

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
        $this->message = null;
        $this->max_invoices_to_view = null;
    }


    public function getInvoicesFromQuery(InvoicesSearchRequest $request)
    {

        $this->max_invoices_to_view = config('partner.last_invoices_to_view', 100);
        $invoices_to_page = config('partner.invoices_to_page', 10);

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
            if ($request->session()->has('atpId') && session('atpId') != 0) {
                $query->where('user_id', '=', session('atpId'));
            }
        }

        $this->countInvoices = $query->count();
        if (!$this->countControl()) {
            // до $this->max_invoices_to_view останніх записів
            $lastInvoice = $query
                ->orderBy('id', 'desc')
                ->skip($this->max_invoices_to_view)
                ->take(1)
                ->get();

            if ($lastInvoice->count() == 1) {
                $lastInvoiceID = $lastInvoice[0]->id;
                $query->where('id', '>', $lastInvoiceID);
            }

        }else{
            $query->orderBy('id', 'desc');

        }
        $invoices = $query
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

    public function getInvoiceById($id)
    {
        $invoice = Invoice::where('id', $id)->with(['products', 'retentions'])->first();
        return $invoice;
    }

    public function getUserCode($edrpou, $identifier)
    {
        $kod = null;
        if (!empty($edrpou)){
            $kod = $edrpou;
        }else{
            if (!empty($identifier)){
                $kod = $identifier;
            }
        }
        return $kod;
    }

    public function sendPdfToPartner($nameFile)
    {
        if (!file_exists($nameFile)){
            $result = ['result' => false , 'message' => 'Відсутній файл' . $nameFile];
            return $result;
        }

        $response = Http::withHeaders([
            'Authorization' => env('TOKEN_VCHASNO'),
        ])
            ->attach('file', file_get_contents($nameFile), $nameFile)
            ->post('https://vchasno.ua/api/v2/documents');

        if ($response->status() === 201){
            $message = 'Успішна передача ' . isset($response->json()['documents'][0]['id']) ? $response->json()['documents'][0]['id'] :  'no ID';
            $result = ['result' => true , 'message' => $message];
            return $result;
        }else{
            $message = isset($response->json()['reason']) ? $response->json()['reason'] : ' без причини.';
            $result = ['result' => false , 'message' => $message];
            return $result;
        }
    }

    public function countControl()
    {
        $this->message = "Увага! По запиту знайдено  {$this->countInvoices}. ";
        if ($this->countInvoices >= $this->max_invoices_to_view) {
            $this->message = "Увага! По запиту знайдено {$this->countInvoices} актів виконаних робіт.
            Для перегляду буде видано тільки <b>{$this->max_invoices_to_view}</b>. Уточніть будь ласка запит.";
            return false;
        } else {
            $this->message = null;
            return true;
        }
    }
}