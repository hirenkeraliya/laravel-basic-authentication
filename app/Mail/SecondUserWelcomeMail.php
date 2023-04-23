<?php

namespace App\Mail;

use App\Models\SecondUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecondUserWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $secondUser;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(SecondUser $secondUser, string $password)
    {
        $this->secondUser = $secondUser;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.second-user-welcome-mail',
        );
    }
}
