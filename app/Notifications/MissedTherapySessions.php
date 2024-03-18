<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MissedTherapySessions extends Notification
{
    use Queueable;

    protected $client;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($notifiable instanceof User && $notifiable->admin == 1) {
            return (new MailMessage)
                ->subject('Missed sessions - Admin')
                ->line('A user: (' . $this->client->client_code . ') has missed more than two therapy sessions.')
                ->line('Please follow up with the user to address the issue.')
                ->line('Thank you for your attention.');
        } else {
            return (new MailMessage)
                ->subject('Missed sessions - Client')
                ->line('Our records show that you have missed two therapy sessions.')
                ->line('Please reach out to your therapist to reschedule or address any issues.')
                ->line('Thank you for your attention.');
        }
    }

}
