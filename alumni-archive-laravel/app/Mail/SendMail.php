<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    public function build()
    {
        return $this->subject('New Message Recieved')
            ->view('mail.mail ')
            ->with(['messageData' => $this->messageData]);
    }
}
