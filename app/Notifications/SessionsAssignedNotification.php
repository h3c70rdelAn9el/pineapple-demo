<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionsAssignedNotification extends Notification
{
    use Queueable;

    protected $client;
    protected $sessionCount;

    /**
     * Create a new notification instance.
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->sessionCount = $client->max_sessions;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The client' . $this->client->preferred_name. 'has been assigned '. $this->sessionCount.'therapy sessions.')
                    ->action('View Client', url('/clients/'. $this->client->id))
                    ->line('Thank you.');
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
