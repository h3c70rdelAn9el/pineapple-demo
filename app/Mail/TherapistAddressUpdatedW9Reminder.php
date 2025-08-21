<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TherapistAddressUpdatedW9Reminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $therapist)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Important: Update Your Tax Documents (W9/W8BEN) - Address Change',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.therapist-address-updated-w9-reminder',
            with: [
                'therapistName' => $this->therapist->preferred_name ?: $this->therapist->name,
                'newAddress' => $this->getFormattedAddress(),
            ],
        );
    }

    /**
     * Get the formatted address for display in the email.
     */
    private function getFormattedAddress(): string
    {
        $addressParts = array_filter([
            $this->therapist->street_address,
            $this->therapist->county_town,
            $this->therapist->state,
            $this->therapist->zip_code_postal_code,
            $this->therapist->country,
        ]);

        return implode(', ', $addressParts);
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
