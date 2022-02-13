<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningCreateReportMail extends Mailable
{
    use Queueable, SerializesModels;
    private $warnings, $ac, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($warnings, $ac, $message)
    {
        $this->warnings = $warnings;
        $this->ac = $ac;
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
            ->subject("Помилки завантаження відомостей по {$this->ac}")
            ->to(config('partner.email.warning_create_report_email'))
            ->view('mail.WarningCreateReports', [
                'warnings' => $this->warnings,
                'ac' => $this->ac,
                'messageToSend' => $this->message,
            ]);
    }
}
