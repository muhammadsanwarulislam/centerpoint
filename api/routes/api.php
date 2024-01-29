<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\Auth\AuthController;
use App\Http\Controllers\Core\Role\RoleManagmentController;
use App\Http\Controllers\Core\Permission\PermissionManagmentController;
use App\Http\Controllers\Core\User\UserManagementController;

// Backend API
/*
    Common API for Backend and Frontend
*/
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/authorized-user-information', [AuthController::class, 'authorizedUserInformation']);
    Route::get('logged-in-user-permission',[AuthController::class,'loggedINUserPermissions']);
    Route::apiResource('users', UserManagementController::class);
    Route::apiResource('roles', RoleManagmentController::class);
    Route::apiResource('permissions', PermissionManagmentController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});