<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredUserConfirmationMail extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->line('Hello '.$notifiable->name)
                    ->line('Hello '.$notifiable->email)
                    ->action('Please click here to visit', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return[
            'name'  => $notifiable->name,
            'email' => $notifiable->email,
        ];
    }
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
