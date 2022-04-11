<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2022
 * Time: 19:48
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Log;

class LoggingRepository
{
    public function createReportsLoggingMessage(string $message)
    {
        Log::channel('download_reports')->debug($message);
    }

    public function createReportsLoggingMessages(array $messages)
    {
        foreach ($messages as $message) {
            Log::channel('download_reports')->debug($message);
        }
    }

    public function createInvoicesLoggingMessage($message)
    {
        Log::channel('download_invoices')->debug($message);
    }

    public function createInvoicesLoggingMessages(array $messages)
    {
        foreach ($messages as $message) {
            Log::channel('download_invoices')->debug($message);
        }
    }

    public function createSendInvoicesLoggingMessage($message)
    {
        Log::channel('send_invoices')->debug($message);
    }
}