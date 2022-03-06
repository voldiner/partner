<?php

namespace App\Http\Controllers;

use App\Repositories\InvoiceRepository;
use App\Repositories\LoggingRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoiceController extends Controller
{
    /**
     * @param InvoiceRepository $invoiceRepository
     * @param NotificationRepository $notificationRepository
     * @param LoggingRepository $loggingRepository
     *  create invoices from uploaded dbf files
     * @return \Illuminate\Http\JsonResponse
     *
     */
   public function createInvoices(
       InvoiceRepository $invoiceRepository,
       NotificationRepository $notificationRepository,
       LoggingRepository $loggingRepository
   )
   {

       $nameInvoicesfile = 'downloads/' . config('partner.download_invoices_file');
       $nameProductsfile = 'downloads/' . config('partner.download_products_file');
       $nameRetentionsfile = 'downloads/' . config('partner.download_retentions_file');

       if (Storage::missing($nameInvoicesfile)) {
           $message = $nameInvoicesfile . ' not exist';
           $loggingRepository->createReportsLoggingMessage($message);
           return response()->json(['error' => $message], 404);
       }
       if (Storage::missing($nameProductsfile)) {
           $message = $nameProductsfile . ' not exist';
           $loggingRepository->createReportsLoggingMessage($message);
           return response()->json(['error' => $message], 404);
       }

       if (Storage::missing($nameRetentionsfile)) {
           $message = $nameRetentionsfile . ' not exist';
           $loggingRepository->createReportsLoggingMessage($message);
           return response()->json(['error' => $message], 404);
       }


      // try {

           $message = $invoiceRepository->createInvoices($nameInvoicesfile, $nameProductsfile, $nameRetentionsfile);
           $loggingRepository->createReportsLoggingMessage($message);
           $loggingRepository->createReportsLoggingMessages($invoiceRepository->warnings);

           $toResponce = $invoiceRepository->createDataResponce($message, $invoiceRepository->warnings);

           $notificationRepository->createInvoicesNotification($invoiceRepository->warnings, $message);

           $invoiceRepository->moveToArchive(
               $nameInvoicesfile,
               $nameProductsfile,
               $nameRetentionsfile,
               $loggingRepository
           );
           return response()->json($toResponce, 200);

      // } catch (\Exception $e) {
     //      $loggingRepository->createInvoicesLoggingMessage($e->getMessage());
      //     return response()->json(['error' => $e->getMessage()], 500);
     //  }

   }

   public function index()
   {

   }

   public function createInvoicePdf($id)
   {

   }
}
