<?php

use App\Http\Controllers\Admin\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders','middleware' => ['auth:admin']], function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::patch('/{order}/update', [OrderController::class, 'update']);
});