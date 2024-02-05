<?php

use App\Http\Controllers\Menu\MenuManageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('menus', MenuManageController::class);
});