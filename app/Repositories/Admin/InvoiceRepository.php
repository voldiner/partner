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
use Illuminate\Support\Facades\Http;
use XBase\TableReader;
use App\Models\Station;
use App\Models\User;
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

            if ($request->session()->has('atpId') && session('atpId') != 0) {
                $conditionsAnd[] = ['user_id', '=', session('atpId')];
            }

            $query->where($conditionsAnd);
            // ----------- OR statement ------------------------- //
            if ($request->has('months')) {
                foreach ($this->monthsFromSelect as $key => $month) {
                    if (in_array($key, $request->get('months'))) {
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
        // якщо розмір колекції перевищує допустимий
        // до $this->max_invoices_to_view останніх записів
        // то відберемо в масив id перших елементів в кількості max_invoices_to_view
        // в подальшому використає даний масив для кінцевого відбору з пагінатором
        if (!$this->countControl()) {
            if ($request->hasAny(['months', 'year'])) {
                // --- якщо це пошук при відборі, то виводим спочатку
                $arrayId = $query->orderBy('id')
                    ->take($this->max_invoices_to_view)
                    ->pluck('id')
                    ->toArray();

                $invoices = Invoice::whereIn('id', $arrayId)
                    ->orderBy('date_invoice')->orderBy('kod_atp')
                    ->with('products')
                    ->with('retentions')
                    ->paginate($invoices_to_page)
                    ->withQueryString();

            } else { // --- інакше виводимо останні
                $arrayId = $query->orderBy('id', 'desc')
                    ->take($this->max_invoices_to_view)
                    ->pluck('id')
                    ->toArray();

                $invoices = Invoice::whereIn('id', $arrayId)
                    ->orderBy('id', 'desc')
                    ->with('products')
                    ->with('retentions')
                    ->paginate($invoices_to_page)
                    ->withQueryString();
            }
        } else {
            $invoices = $query
                ->orderBy('date_invoice')->orderBy('kod_atp')
                ->with('products')
                ->with('retentions')
                ->paginate($invoices_to_page)
                ->withQueryString();
        }


        return $invoices;
    }

    public function getUsersToSelect()
    {
        $users = User::where('user_type', '=', 1)
            ->where('is_active', '=', 1)
            ->pluck('id', 'short_name');
        $users->prepend(0, 'не вказано');
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
        if (!empty($edrpou)) {
            $kod = $edrpou;
        } else {
            if (!empty($identifier)) {
                $kod = $identifier;
            }
        }
        return $kod;
    }

    public function sendPdfToPartner($nameFile)
    {
        if (!file_exists($nameFile)) {
            $result = ['result' => false, 'message' => 'Відсутній файл' . $nameFile];
            return $result;
        }

        $response = Http::withHeaders([
            //'Authorization' => env('TOKEN_VCHASNO'),
            'Authorization' => 'Wty3MUVfRj0Q0M43kyKWlB-gOKjSW13924xp',

        ])
            ->attach('file', file_get_contents($nameFile), $nameFile)
            ->post('https://vchasno.ua/api/v2/documents');

        if ($response->status() === 201) {
            $message = 'Успішна передача ' . isset($response->json()['documents'][0]['id']) ? $response->json()['documents'][0]['id'] : 'no ID';
            $result = ['result' => true, 'message' => $message];
            return $result;
        } else {
            $message = isset($response->json()['reason']) ? $response->json()['reason'] : ' без причини.';
            $result = ['result' => false, 'message' => $message];
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

    /**
     * @param $month integer
     * @param $year integer
     * @return array
     */
    public function getInvoicesForSummary($month, $year)
    {
        $invoices = Invoice::where('month', '=', $month)
            ->where('year', '=', $year)
            ->with(['products', 'retentions', 'user'])
            ->orderBy('kod_atp')
            ->get();
        $dateCreate = date("m.d.Y G:i:s");
        $counter = 0;
        $result = [];
        foreach ($invoices as $invoice) {
            $result[$counter] = [$invoice->kod_atp];
            array_push($result[$counter], $invoice->user->short_name);
            if ($invoice->balance_begin > 0) {
                array_push($result[$counter], 0, $invoice->balance_begin);
            } elseif ($invoice->balance_begin < 0) {
                array_push($result[$counter], $invoice->balance_begin * -1, 0);
            } else {
                array_push($result[$counter], 0, 0);
            }
            $sumTariff = 0;
            $sumBaggage = 0;
            $sumInsurance = 0;
            foreach ($invoice->products as $product) {
                $sumTariff += $product->sum_tariff;
                $sumBaggage += $product->sum_baggage;
                $sumInsurance += $product->sum_insurance;
            }
            // утримано по угоді
            $sumUg = 0;
            // утримано за квитки
            $sumTic = 0;
            // утримано ПДВ
            $sumPDV = 0;
            // утримано за кімнату відпочинку
            $sumKim = 0;
            // утримано по акту
            $sumAkt = 0;
            // Дорахування від обов"язкового страхуванн
            $sumStr = 0;
            foreach ($invoice->retentions as $retention) {
                if ($retention->name == 'Утримано згідно угоди') {
                    $sumUg += $retention->sum;
                } elseif ($retention->name == 'Утримано за квитки') {
                    $sumTic += $retention->sum;
                } elseif ($retention->name == 'Утримано ПДВ') {
                    $sumPDV += $retention->sum;
                } elseif ($retention->name == 'Утримано за кімнату відпочинку') {
                    $sumKim += $retention->sum;
                } elseif ($retention->name == 'Утримано згідно актів контролю') {
                    $sumAkt += $retention->sum;
                }elseif ($retention->name == 'Дорахування від обов"язкового страхуванн') {
                    $sumStr += $retention->sum;
                }
            }

            array_push($result[$counter], $sumTariff, $sumBaggage, $sumInsurance);
            array_push($result[$counter],
                $invoice->calculation_for_billing,
                $sumStr,
                $invoice->calculation_for_baggage,
                $invoice->sum_for_transfer,
                $invoice->sum_month_transfer,
                $sumUg,
                $sumTic,
                $sumPDV,
                $sumKim,
                $sumAkt,
                $invoice->get_cash,
                $invoice->retention_for_collection
            );

            if ($invoice->balance_end > 0) {
                array_push($result[$counter], 0, $invoice->balance_end);
            } elseif ($invoice->balance_end < 0) {
                array_push($result[$counter], $invoice->balance_end * -1, 0);
            } else {
                array_push($result[$counter], 0, 0);
            }

            $counter++;
        }

        if (count($result)) {
            $total = [0, 0];
            $countColumn = count($result[0]);
            for ($i = 2; $i < $countColumn; $i++) {
                $totalSum = 0;
                foreach ($result as $item) {

                    $totalSum += $item[$i];
                }
                array_push($total, $totalSum);
            }
            array_push($result, $total);
            array_unshift($result,
                [
                    'код',
                    'назва',
                    'залишок на початок дебет',
                    'залишок на початок кредит',
                    'сума реалізації',
                    'сума багажу',
                    'сума страховий збір',
                    'відрахування від виручки',
                    'відрахування від страхового збору',
                    'відрахування від багажу',
                    'сума до перерахування',
                    'перераховано за місяць',
                    'утримано по угоді',
                    'утримано за квитки',
                    'утримано ПДВ',
                    'утримано за кімнату відпочинку',
                    'утримано по акту',
                    'видано з каси',
                    'утримано за інкасацію',
                    'залишок на кінець дебет',
                    'залишок на кінець кредит',
                ]
            );
            array_unshift($result, ["Оборотна відомість за {$this->monthsFromSelect[$month]} місяць {$year} року (надруковано {$dateCreate})"]);
            return $result;
        }
        return [];
    }
}