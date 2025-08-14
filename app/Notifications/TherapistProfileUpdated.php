<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TherapistProfileUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;

    protected $updatedFields;

    public function __construct($user, $updatedFields)
    {
        $this->user = $user;
        $this->updatedFields = $updatedFields;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // use Illuminate\Notifications\Messages\MailMessage;

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->line('A therapist has updated their profile:')
            ->line('Therapist Name: '.$this->user->name)
            ->line('Therapist ID: '.$this->user->id)
            ->line('Updated Fields:');

        foreach ($this->updatedFields as $field => $value) {
            $message->line(ucwords(str_replace('_', ' ', $field)).': '.$value);
        }

        $message->action('View Profile', url('/therapist/'.$this->user->id));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
