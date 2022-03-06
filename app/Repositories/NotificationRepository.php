<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2022
 * Time: 19:36
 */

namespace App\Repositories;


use App\Mail\WarningCreateInvoiceMail;
use App\Mail\WarningCreateReportMail;
use Illuminate\Support\Facades\Mail;

class NotificationRepository
{
    public function createReportsNotification(array $warnings, string $message)
    {
        if (count($warnings)){
            Mail::send(new WarningCreateReportMail($warnings, $message));
        }

    }

    public function createInvoicesNotification(array $warnings, string $message)
    {
        if (count($warnings)){
            Mail::send(new WarningCreateInvoiceMail($warnings, $message));
        }

    }

}