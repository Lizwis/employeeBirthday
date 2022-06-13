<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class employeeMail extends Mailable
{
    use Queueable, SerializesModels;

   public $birthdayNames;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($birthdayNames)
    {
        $this->birthdayNames = $birthdayNames;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.birthday');
    }
}
