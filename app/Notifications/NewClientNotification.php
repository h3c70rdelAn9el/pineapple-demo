<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewClientNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject('Pineapple Support - New Client')
            ->line('Hello, we are informing you that you have been assigned a new client. Please log in to your dashboard to view the client.')
            ->line(new htmlString('<strong>Pineapple Support updated onboarding – please remember to assess and grant the client 8, 12 or 16 sessions depending on the level of support required. Pineapple Support is working at maximum capacity and your support is needed to help us reduce our waitlist for therapy services.</strong>'))
            ->action('Please log in to your dashboard.', url('/login'))
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
