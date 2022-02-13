<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2022
 * Time: 19:36
 */

namespace App\Repositories;


use App\Mail\WarningCreateReportMail;
use App\Models\Station;
use Illuminate\Support\Facades\Mail;

class NotificationRepository
{
    public function createReportsNotification(array $warnings, Station $station, string $message)
    {
        if (count($warnings)){
            Mail::send(new WarningCreateReportMail($warnings, $station->name, $message));
        }

    }

}