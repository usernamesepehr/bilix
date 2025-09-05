<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $name;
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
         $htmlContent = "
            <h1>خوش امدید, {$this->name}!</h1>
            <p>خوشحالیم که به ما پیوستید.</p>
        ";

        return $this->subject("خوش امدید به اپلیکیشن ما")->html($htmlContent);
    }
}
