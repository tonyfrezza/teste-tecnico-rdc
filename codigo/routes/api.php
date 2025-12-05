<?php

use App\Http\Controllers\Api\Orders\CreateController;
use App\Http\Controllers\Api\Orders\DestroyController;
use App\Http\Controllers\Api\Orders\IndexController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Orders\UpdateStatusController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as'            =>  'api.',
], function () {
    Route::group([
        'as'            =>  'orders.',
    ], function () {
        Route::get('/orders', IndexController::class)->name('index');
        Route::get('/orders/{id}', OrderController::class)->name('show');
        Route::post('/orders', CreateController::class)->name('create');
        Route::put('/orders/{id}/status', UpdateStatusController::class)->name('update');
        Route::delete('/orders/{id}', DestroyController::class)->name('destroy');
    });
});
