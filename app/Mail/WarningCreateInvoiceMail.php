<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningCreateInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    private $warnings, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($warnings, $message)
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
            ->subject("Помилки завантаження актів звірки")
            ->to(config('partner.email.warning_create_invoice_email'))
            ->view('mail.WarningCreateInvoices', [
                'warnings' => $this->warnings,
                'messageToSend' => $this->message,
            ]);
    }
}
