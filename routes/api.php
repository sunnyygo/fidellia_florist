<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\OrderController;

Route::post('/midtrans-callback', [OrderController::class, 'callback']);