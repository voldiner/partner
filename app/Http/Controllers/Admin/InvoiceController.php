<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoicesSearchRequest;
use App\Models\Invoice;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Controller as Controller;
use App\Repositories\Admin\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

    public function index(InvoicesSearchRequest $request, InvoiceRepository $invoiceRepository)
    {

        $invoices = $invoiceRepository->getInvoicesFromQuery($request);

        $countInvoices = $invoiceRepository->countInvoices;
        $monthsFromSelect = $invoiceRepository->monthsFromSelect;
        $monthsSelected = $invoiceRepository->monthsSelected;
        $year = $invoiceRepository->year;
        $users = $invoiceRepository->getUsersToSelect();

        return view('admin.invoices', compact
        (
            'invoices',
            'countInvoices',
            'monthsFromSelect',
            'monthsSelected',
            'year',
            'users'
        ));

    }

    public function createInvoicePdf($id, InvoiceRepository $invoiceRepository)
    {

        $invoice = Invoice::where('id', $id)->with(['products', 'retentions'])->first();
        if (!$invoice) {
            abort(404);
        }

        /* if (session()->has('atpId')){
             if ($invoice->user_id !== session('atpId')) {
                 abort(403);
             }
         }*/

        $monthsFromSelect = $invoiceRepository->monthsFromSelect;

        $pdf = PDF::loadView('pdf.invoice', compact(
            'invoice',
            'monthsFromSelect'
        ));

        return $pdf->download('invoice.pdf');
    }

    public function sendInvoiceToPartner(Request $request, InvoiceRepository $invoiceRepository)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        $dateToMessage = Carbon::now()->format('d-m-Y G:i:s');
        $textError = '<span style="color: red;"> Помилка! </span>';
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' =>  "{$dateToMessage} {$textError} Error Invoice id from request"], 200);
        }

        $id = $request->get('id');
        try {

            $invoice = Invoice::where('id', $id)->with(['products', 'retentions'])->first();
            if (!$invoice) {
                return response()->json(['error' => true, $dateToMessage . 'message' => $dateToMessage . "{$textError} Invoice id={$id} not found"], 200);
            }
            $monthsFromSelect = $invoiceRepository->monthsFromSelect;
            // ----- name file
            if (is_null($invoice->user->email_verified_at)) {
                return response()->json(['error' => true, 'message' => "{$dateToMessage} {$textError} Користувач {$invoice->user->short_name } не має підтвердженого email"], 200);
            }
            $email = $invoice->user->email;
            $kod = null;
            if (!empty($invoice->user->edrpou)){
                $kod = $invoice->user->edrpou;
            }else{
                if (!empty($invoice->user->identifier)){
                    $kod = $invoice->user->identifier;
                }
            }
            if (is_null($kod)){
                return response()->json(['error' => true, 'message' => "{$dateToMessage} {$textError} Користувач {$invoice->user->short_name } не має ані коду ЄДРПОУ, ні коду ІПН"], 200);
            }
            $date = $invoice->date_invoice->format('Ymd');
            $num = $invoice->number;
            $nameFile = storage_path("app\send\\03113130_{$kod}_{$date}_АктЗвірки_{$num}_{$email}.pdf");
            // ---------------
            //throw new \Exception('Testing exception!!!');

            PDF::loadView('pdf.invoice', compact(
                'invoice',
                'monthsFromSelect'
            ))->save($nameFile);
        } catch (Exception $exception) {
            return response()->json(['error' => true, 'message' => $dateToMessage . ' ' . $textError . $exception->getMessage()], 200);
        }

        //dd(Storage::exists($nameFile));
        //dd($nameFile);
//        $response = Http::withHeaders([
//            'Authorization' => 'Wty3MUVfRj0Q0M43kyKWlB-gOKjSW13924xp',
//        ])
//            ->attach('file', file_get_contents($nameFile), '03113130_3481008043_20220403_АктЗвірки_8702-025_voldiner@ukr.net.pdf')
//            ->post('https://vchasno.ua/api/v2/documents');
//
//        dd($response->json());
        // ------- проставити відмітку counter_sending
        $invoice->counter_sending++;
        $invoice->save();
        // ----------------------------------------------
        $result['success'] = true;
        $result['id'] = $id;
        $result['message'] = $dateToMessage . '  Акт №' . $invoice->number . ' перевізник ' . $invoice->user->short_name . 'успішно передано в ВЧАСНО';
        $result['counter'] = $invoice->counter_sending;
        return response()->json($result, 200);
    }
}
