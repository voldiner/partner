<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningCreateReportMail extends Mailable
{
    use Queueable, SerializesModels;
    private $warnings, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($warnings, $ac, $message)
    {
        $this->warnings = $warnings;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject("Помилки завантаження відомостей")
            ->to(config('partner.email.warning_create_report_email'))
            ->view('mail.WarningCreateReports', [
                'warnings' => $this->warnings,
                'messageToSend' => $this->message,
            ]);
    }
}
