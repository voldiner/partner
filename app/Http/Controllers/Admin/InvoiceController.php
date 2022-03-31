<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoicesSearchRequest;
use App\Models\Invoice;
use App\Http\Controllers\Controller as Controller;
use App\Repositories\Admin\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

        $invoice = Invoice::where('id', $id)->with(['products','retentions'])->first();
        if (!$invoice){
            abort(404);
        }

        if (session()->has('atpId')){
            if ($invoice->user_id !== session('atpId')) {
                abort(403);
            }
        }

        $monthsFromSelect = $invoiceRepository->monthsFromSelect;

        $pdf = PDF::loadView('pdf.invoice', compact(
            'invoice',
            'monthsFromSelect'
        ));

        return $pdf->download('invoice.pdf');
    }
}
