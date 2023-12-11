<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['json'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('admin.login');
        Route::post('logout', 'logout')->name('admin.logout');
        Route::post('me', 'me')->name('admin.me');
    });

    Route::middleware(['auth:admin-api'])->group(function () {
        Route::apiResource('clients', ClientController::class)->names('admin.clients');
        Route::apiResource('products', ProductController::class)->names('admin.products');
        Route::apiResource('product-categories', ProductCategoryController::class)->names('admin.product-categories');
        Route::apiResource('orders', OrderController::class)->names('admin.orders');
    });

});
