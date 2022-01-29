<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisterMessageForAdmin extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject("Користувач {$this->name} успішно зареєструвався!")
            ->to(config('partner.email.admin_email'))
            ->view('mail.UserRegisterMessageForAdmin', [
                'name' => $this->name,
                'id' => $this->id,
            ]);
    }
}
