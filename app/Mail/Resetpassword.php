<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jelszó visszaállítása',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // A jelszó visszaállító URL létrehozása
        $resetUrl = url('/reset-password/' . $this->mailData['token']); // A reset URL

        return new Content(
            view: 'mails.ResetPasswordTemplate', // Az email sablon
            with: [
                'user' => $this->mailData['user'], // Felhasználó neve
                'resetUrl' => $resetUrl, // A generált URL
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
