<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentsMissing extends Notification
{
    use Queueable;

    protected $documents;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $documents)
    {
        $this->documents = $documents;
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
            ->subject('Missing Required Documents - Action Required')
            ->line('We notice that you have not yet uploaded some required documents to your therapist portal.')
            ->line('The following documents are missing: '.$this->documents)
            ->line('Please log in to your portal and upload these documents as soon as possible to continue receiving client referrals.')
            ->action('Upload Missing Documents', url(route('profile.show')))
            ->line('If you have any questions about the required documents, please contact kellie@pineapplesupport.org');
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
