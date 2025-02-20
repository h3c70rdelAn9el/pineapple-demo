<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientSessionsAllocated extends Mailable
{
    use Queueable, SerializesModels;

    private $preferred_name;
    private $number_of_sessions;
    /**
     * Create a new message instance.
     */
    public function __construct($preferred_name, $number_of_sessions)
    {
        $this->preferred_name = $preferred_name;
        $this->number_of_sessions = $number_of_sessions;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pineapple Support Session Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client-sessions-allocated',
            with: [
                'preferred_name' => $this->preferred_name,
                'number_of_sessions' => $this->number_of_sessions,
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
