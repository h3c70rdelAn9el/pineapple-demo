<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientMadeInactiveNotification extends Notification
{
    use Queueable;

    protected $client;
    protected $therapistName;

    /**
     * Create a new notification instance.
     */
    public function __construct($client, $therapistName)
    {
        $this->client = $client;
        $this->therapistName = $therapistName;
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
            ->line('The client ' . $this->client->client_code . 'assigned to' . $this->therapistName . 'has been made inactive.')
            ->action('View Client', url('/clients/' . $this->client->id))
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
