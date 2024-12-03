<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Reply extends Mailable
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
            ->view('mail.reply ')
            ->with(['messageData' => $this->messageData]);
    }
}
