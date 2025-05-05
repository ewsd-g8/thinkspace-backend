<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::apiResources([
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
    Route::get('users/change-status/{user}', [UserController::class, 'changeStatus']);

    Route::get('auth-user', [AuthController::class, 'getAuthUser']);
    Route::get('/get-all-roles', [UserController::class, 'getRoles']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
});

//dummy api for dropzone
Route::get('/dummy-data', function () {
    return 'dummy';
});
