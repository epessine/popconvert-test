<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::prefix('v1')->group(function () {
    Route::resource('orders', OrderController::class)->only(['store']);
});
