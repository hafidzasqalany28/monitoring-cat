<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CatFarFromHomeNotification extends Notification
{
    use Queueable;
    public $distance;

    public function __construct($data)
    {
        $this->distance = $data['distance'];
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
            ->greeting('Hello!')
            ->line('Your cat is far from home.')
            ->line('Distance: ' . $this->distance . ' meters')
            ->action('View Location', url('/home'))
            ->line('Please check the location.')
            ->line('Thank you!')
            ->salutation('Regards, cat-tracker');
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
