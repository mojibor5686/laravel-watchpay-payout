<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WithdrawalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/webhooks/withdraw/notify', [WithdrawalController::class, 'withdraw_notify'])->name('withdraw.notify');