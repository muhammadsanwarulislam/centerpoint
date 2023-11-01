<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisteredUserConfirmationMail;

class UserCreatedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        Notification::send($event->user, new RegisteredUserConfirmationMail($event->user));
    }
}
