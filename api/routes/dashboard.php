<?php

use App\Http\Controllers\Dashboard\DashboardManageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('dashboard', [DashboardManageController::class,'index']);
});