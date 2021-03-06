<?php

namespace App\Http\Controllers\Admin;

use App\Actions\InvoicesExport;
use App\Http\Requests\InvoicesSearchRequest;
use App\Http\Requests\InvoicesSearchSummary;
use App\Models\Invoice;
use App\Repositories\LoggingRepository;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Controller as Controller;
use App\Repositories\Admin\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        $message = $invoiceRepository->message;
        return view('admin.invoices', compact
        (
            'invoices',
            'countInvoices',
            'monthsFromSelect',
            'monthsSelected',
            'year',
            'users',
            'message'
        ));

    }

    public function createInvoicePdf($id, InvoiceRepository $invoiceRepository)
    {

        $invoice = Invoice::where('id', $id)->with(['products', 'retentions'])->first();
        if (!$invoice) {
            abort(404);
        }


        $monthsFromSelect = $invoiceRepository->monthsFromSelect;

        $pdf = PDF::loadView('pdf.invoice', compact(
            'invoice',
            'monthsFromSelect'
        ));

        return $pdf->download('invoice.pdf');
    }

    public function sendInvoiceToPartner(
        Request $request,
        InvoiceRepository $invoiceRepository,
        LoggingRepository $loggingRepository
    )
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        $dateToMessage = Carbon::now()->format('d-m-Y G:i:s');
        $textError = '<span style="color: red; background-color: yellow"> ??????????????! </span>';
        if ($validator->fails()) {
            $message = "{$dateToMessage} {$textError} Error Invoice id from request";
            $loggingRepository->createSendInvoicesLoggingMessage($message);
            return response()->json(['error' => true, 'message' => $message ], 200);
        }

        $id = $request->get('id');
        try {
            $invoice = $invoiceRepository->getInvoiceById($id);

            if (!$invoice) {
                $message = $dateToMessage . "{$textError} Invoice id={$id} not found";
                $loggingRepository->createSendInvoicesLoggingMessage($message);
                return response()->json(['error' => true, $dateToMessage . 'message' => $message], 200);
            }
            $monthsFromSelect = $invoiceRepository->monthsFromSelect;

            if (is_null($invoice->user->email_verified_at)) {
                $message = "{$dateToMessage} {$textError} ???????????????????? {$invoice->user->short_name } ???? ?????? ???????????????????????????? email";
                $loggingRepository->createSendInvoicesLoggingMessage($message);
                return response()->json(['error' => true, 'message' => $message ], 200);
            }
            $email = $invoice->user->email;

           $kod = $invoiceRepository->getUserCode($invoice->user->edrpou, $invoice->user->identifier);

            if (is_null($kod)){
                $message = "{$dateToMessage} {$textError} ???????????????????? {$invoice->user->short_name } ???? ?????? ?????? ???????? ????????????, ???? ???????? ??????";
                $loggingRepository->createSendInvoicesLoggingMessage($message);
                return response()->json(['error' => true, 'message' => $message], 200);
            }
            $date = $invoice->date_invoice->format('Ymd');
            $num = $invoice->number;
            $nameFile = storage_path("app/send/03113130_{$kod}_{$date}_??????????????????_{$num}_{$email}.pdf");
            // ---------------
            //throw new \Exception('Testing exception!!!');

            PDF::loadView('pdf.invoice', compact(
                'invoice',
                'monthsFromSelect'
            ))->save($nameFile);


             $transfer = $invoiceRepository->sendPdfToPartner($nameFile);

             if (!$transfer['result']){
                 $message = "{$dateToMessage} {$textError} ?????? ??? {$invoice->number} ?????????????????????? {$invoice->user->short_name } ?????????????? ???????????????? ???? ???????????? ???????????? ({$transfer['message']})";
                 $loggingRepository->createSendInvoicesLoggingMessage($message);
                 return response()->json(['error' => true, 'message' => $message ], 200);
             }


        } catch (Exception $exception) {
            $message = $dateToMessage . ' ' . $textError . $exception->getMessage();
            $loggingRepository->createSendInvoicesLoggingMessage($message);
            return response()->json(['error' => true, 'message' => $message], 200);
        }

        $invoice->counter_sending++;
        $invoice->save();

        $result['success'] = true;
        $result['id'] = $id;
        $result['message'] = $dateToMessage . '  ?????? ???' . $invoice->number . ' ???????????????????? ' . $invoice->user->short_name . '?????????????? ???????????????? ?? ???????????? (id = ' . $transfer['message'] . ')';
        $result['counter'] = $invoice->counter_sending;
        $loggingRepository->createSendInvoicesLoggingMessage($result['message']);
        return response()->json($result, 200);
    }

    public function summary(InvoiceRepository $invoiceRepository)
    {
        $monthsFromSelect = $invoiceRepository->monthsFromSelect;
        $users = $invoiceRepository->getUsersToSelect();
        $message = $invoiceRepository->message;

        $monthsSelected = [];
        $year = null;

        return view('admin.invoices_summary',compact
        (
            'monthsFromSelect',
            'monthsSelected',
            'year',
            'users',
            'message'
        ));
    }

    public function createTableSummary(InvoicesSearchSummary $request, InvoiceRepository $invoiceRepository)
    {

        $invoices = $invoiceRepository->getInvoicesForSummary($request->month, $request->year);

        if (count($invoices)){

            return Excel::download(new InvoicesExport($invoices), 'invoices.xls', \Maatwebsite\Excel\Excel::XLS);

        }else{
            return back()->with(['error' => "?????????? ???? {$invoiceRepository->monthsFromSelect[$request->month]} {$request->year} ???? ????????????????" ]);
        }


    }
}
