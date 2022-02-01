<?php

namespace App\Service;

use Illuminate\Support\Facades\Facade;

class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Service\UserService';
    }
}
