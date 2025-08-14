<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientRemovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $clientName;

    public function __construct($clientName)
    {
        $this->clientName = $clientName;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pineapple Support - Client Reassigned')
            ->line('The client '.$this->clientName.' assigned to you has been reassigned to another therapist.')
            ->line('Thank you for your attention!');
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
