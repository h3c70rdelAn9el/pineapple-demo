<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentsExpired extends Notification
{
    use Queueable;
    protected $documents;
    /**
     * Create a new notification instance.
     */
    public function __construct(String $documents)
    {
        $this->documents = $documents;


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
            ->cc('kellie@pineapplesupport.org')
            ->line('Please note that we require your up-to-date documents to be updated on the portal. If you can log in and update as soon as possible.')
            ->line('The following documents have expired:' . $this->documents)
            ->action('Please log in and upload new documents', url(route('profile.show')))
            ->line('Please note, should the document not be updated, we may not be able to allocate new clients to you.')
            ->line('Should you have any queries please contact kellie@pineapplesupport.org');
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
