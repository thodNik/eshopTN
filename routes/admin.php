<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['json'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('admin.login');
        Route::post('logout', 'logout')->name('admin.logout');
        Route::post('me', 'me')->name('admin.me');
    });

    Route::middleware(['admin-api'])->group(function () {
        Route::apiResource('clients', ClientController::class)->names('admin.clients');
    });

});
