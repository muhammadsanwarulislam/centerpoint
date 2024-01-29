<?php

namespace App\Listeners;

use Repository\User\UserRepository;
use App\Events\LoggedInUserAccessTokenStoreEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoggedInUserAccessTokenStoreListener
{
    protected $userRepository;
    /**
     * Create the event listener.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository   =  $userRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedInUserAccessTokenStoreEvent $event): void
    {
        $this->userRepository->updateByModelCondition(
            ['id' => $event->data['user']->id],
            'remember_token',
            $event->data['access_token']);
    }
    
}
