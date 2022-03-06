<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.03.2022
 * Time: 9:41
 */

namespace App\Repositories;


use App\Models\Invoice;
use App\Models\Product;
use XBase\TableReader;
use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class InvoiceRepository
{
    public $warnings;
    protected $stations;
    public function __construct()
    {
        $this->warnings = [];
        $this->stations = Station::all();
    }

    /**
     * create Invoices and relations Products, Retentions from dbf files
     *
     * @return string
     * @throws \Exception
     */
    public function createInvoices($nameInvoicesFile, $nameProductsFile, $nameRetentionsFile)
    {
        $tableInvoices = new TableReader(
            storage_path('app/' . $nameInvoicesFile),
            [
                'encoding' => 'cp866'
            ]
        );
        $tableProducts = new TableReader(
            storage_path('app/' . $nameProductsFile),
            [
                'encoding' => 'cp866'
            ]
        );
        $tableRetentions = new TableReader(
            storage_path('app/' . $nameRetentionsFile),
            [
                'encoding' => 'cp866'
            ]
        );

        //throw new \Exception('Testing exception!!!');
        $countInvoicesAdd = 0;
        $countInvoicesUpdate = 0;
        $countInvoicesAll = 0;
        $startTime = time();

        $users = User::where('user_type', 1)
            ->select(['id', 'name', 'kod_fxp'])
            ->get()
            ->toBase();

        while ($record = $tableInvoices->nextRecord()) {

            $countInvoicesAll++;
            // ------ валідація -------- //
            if (!$this->validateRecord($record)) {
                continue;
            }
            $user_id = $this->getUserId($users, $record);

            if ($user_id === 0) {
                continue;
            }

            $products = $this->getProductsFromDBF($record->get('number'), $tableProducts);
            if (!$products) {
                continue;
            }
            // ----- визначим додавати нову відомість чи коректувати стару ------- //
            $invoice = Invoice::where([
                ['kod_atp', '=', $record->get('atp')],
                ['month', '=', $record->get('mis')],
                ['year', '=', $record->get('rik')],
            ])->first();

            if ($invoice) {
                // видалити  places ,оновити report
                $invoice->products()->delete();
                $countInvoicesUpdate++;
            } else {
                $invoice = new Invoice();
                $countInvoicesAdd++;
            }

            $this->fillInvoice($invoice, $record, $user_id);

            $invoice->save();

            $invoice->products()->saveMany($products);
        }
        $timeWork = time() - $startTime;
        $result = "Processed {$countInvoicesAll} record. Add {$countInvoicesAdd} reports. Update {$countInvoicesUpdate} reports. Time {$timeWork} sec.";
        return $result;

    }

    /**
     * валідація строки з dbf file
     * @param XBase\Record\DBaseRecord $record
     * @return bool
     */
    protected function validateRecord($record)
    {
        $result = true;
        if (!is_numeric($record->get('atp')) || $record->get('atp') == 0) {
            $this->warnings[] = " Error validate atp " . $record->get('atp') . " invoice #" . $record->get('number');
            $result = false;
            dump("Error validate atp " . $record->get('atp') . " invoice #" . $record->get('number'));
        }

        if (!$this->validateDMY(1, $record->get('mis'), $record->get('rik'))) {
            $result = false;
            $this->warnings[] = "Error validate month, year  invoice #" . $record->get('number');
            dump("Error validate month, year  invoice #" . $record->get('number'));
        }
        return $result;
    }

    /**
     * валідація дня місяця року
     * @param int $day
     * @param int $month
     * @param int $year
     * @return bool
     */
    protected function validateDMY($day, $month, $year)
    {
        $resultDay = true;
        $resultMonth = true;
        $resultYear = true;
        if ($day <= 0 || $day > 31) {
            $resultDay = false;
        }
        if ($month <= 0 || $month > 12) {
            $resultMonth = false;
        }
        if ($year < 2000 || $year > 2100) {
            $resultYear = false;
        }
        if ($resultDay && $resultMonth && $resultYear) {
            return true;
        }
        return false;
    }

    /**
     * @param XBase\Record\DBaseRecord $record
     * @param Collection $users
     * @return int
     */
    protected function getUserId($users, $record)
    {
        $user = $users->firstWhere('kod_fxp', '=', $record->get('atp'));
        if ($user) {
            $result = $user->id;
        } else {
            $result = 0;
            $this->warnings[] = 'Error not found user_id ' . $record->get('atp') . ' invoice #' . $record->get('number');
            dump(" Error not found user_id " . $record->get('atp') . " invoice #" . $record->get('number'));
        }
        return $result;
    }

    protected function getProductsFromDBF($numInvoice, $table)
    {
        $result = [];
        $table->moveTo(0);
        while ($record = $table->nextRecord()) {
            if ($numInvoice === $record->get('invoice')) {
                $stationID = $this->getStation($record)->id;
                // todo обробка коли не знайшлося станції в продукт
                $result[] = new Product([
                    'num_invoice' => $record->get('invoice'),
                    'kod_ac' => $record->get('kod_ac'),
                    'sum_tariff' => $record->get('suma'),
                    'sum_baggage' => $record->get('sumb'),
                    'sum_insurance' => $record->get('zbir'),
                    'station_id' => $stationID,
                ]);
            }
        }
        if (count($result) === 0) {
            $this->warnings[] = " Error not found products invoice #{$numInvoice} ";
            dump(" Error not found products invoice #{$numInvoice}");
            return false;
        }
        return $result;
    }

    /**
     * @param XBase\Record\DBaseRecord $record
     * @param Collection $stations
     * @return Model | null
     */
    protected function getStation($record)
    {
        $station = $this->stations->firstWhere('kod', '=', $record->get('kod_ac'));
        if (!$station) {
            $this->warnings[] = "Error not found station_id " . $record->get('kod_ac') . " invoice #" . $record->get('number');
            dump("Error not found station_id " . $record->get('kod_ac') . " invoice #" . $record->get('number'));
        }
        return $station;
    }

    /**
     * @param Invoice $invoice
     * @param XBase\Record\DBaseRecord $record
     * @param int $user_id
     */
    protected function fillInvoice($invoice, $record, $user_id)
    {
        $invoice->kod_atp = $record->get('atp');
        $invoice->number = $record->get('number');
        $invoice->date_invoice = $record->get('date');
        $invoice->month_status = $record->get('mis_zv');
        $invoice->year_status  = $record->get('rik_zv');
        $invoice->month = $record->get('mis');
        $invoice->year = $record->get('rik');
        $invoice->balance_begin = $record->get('ostatok_n');
        $invoice->calculation_for_billing = $record->get('utr_suma');
        $invoice->calculation_for_baggage = $record->get('utr_sumb');
        $invoice->sum_for_transfer = $record->get('sum_per_d');
        $invoice->sum_month_transfer = $record->get('sum_per');
        $invoice->get_cash = $record->get('gotivka');
        $invoice->balance_end = $record->get('ostatok_k');
        $invoice->balance_for_who = $record->get('saldo_who');
        $invoice->pdv = $record->get('pdv');
        $invoice->sum_for_tax = $record->get('sum_podat');
        $invoice->user_id = $user_id;
    }

    /**
     * @param string $message
     * @param array $warnings
     * @return array
     */
    public function createDataResponce(string $message, array $warnings)
    {
        $result = ['success' => $message];
        if (count($warnings)) {
            $result['warnings'] = $warnings;
        }
        return $result;
    }

    public function moveToArchive(
        $nameReportsFile,
        $namePlacesFile,
        $nameRetentionsFile,
        LoggingRepository $loggingRepository
    )
    {
        $nameInvoiceArchive = 'invoices/' . date("Y_m_d_H_i_s_") . $nameReportsFile;
        $nameProductArchive = 'invoices/' . date("Y_m_d_H_i_s_") . $namePlacesFile;
        $nameRetentionArchive = 'invoices/' . date("Y_m_d_H_i_s_") . $nameRetentionsFile;
        try {
            //throw new \Exception('Testing exception!!!');
            Storage::move('downloads/' . $nameReportsFile, $nameInvoiceArchive);
            Storage::move('downloads/' . $namePlacesFile, $nameProductArchive);
            Storage::move('downloads/' . $nameRetentionsFile, $nameRetentionArchive);
        } catch (\Exception $e) {
            $loggingRepository->createInvoicesLoggingMessage($e->getMessage());

        }
    }
}