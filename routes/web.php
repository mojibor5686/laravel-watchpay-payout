<?php

use App\Http\Controllers\GatewayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    // Helpdesk & System Logs
    Route::get('/system/login/history', [SystemController::class, 'loginHistory'])->name('system.login.history');
    Route::get('/system/health', [SystemController::class, 'health'])->name('system.health');
    Route::get('/system/logs', [SystemController::class, 'systemLogs'])->name('system.logs');

    // Gateway Routes
    Route::get('/gateways', [GatewayController::class, 'index'])->name('gateways.index');
    Route::post('/gateways', [GatewayController::class, 'store'])->name('gateways.store');

    // Withdrawal Management Routes
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [WithdrawalController::class, 'index'])->name('index');
        Route::get('/pending', [WithdrawalController::class, 'pending'])->name('pending');
        Route::get('/approved', [WithdrawalController::class, 'approved'])->name('approved');
        Route::get('/rejected', [WithdrawalController::class, 'rejected'])->name('rejected');
        Route::get('/create', [WithdrawalController::class, 'create'])->name('create');
        Route::post('/store', [WithdrawalController::class, 'store'])->name('store');
        Route::patch('/{id}/status', [WithdrawalController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}/cancel', [WithdrawalController::class, 'destroy'])->name('destroy');
    });

    Route::get('/send-to-api/{id}', [WithdrawalController::class, 'initiateWithdraw'])->name('send_to_api');

    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Setting Routes
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'store'])->name('setting.store');

    // System Optimization Routes
    Route::post('/system/clear-cache', [SystemController::class, 'clearCache'])->name('system.clearCache');
    Route::post('/system/clear-route', [SystemController::class, 'clearRoute'])->name('system.clearRoute');
    Route::post('/system/clear-logs', [SystemController::class, 'clearLogs'])->name('system.clearLogs');
    Route::post('/system/storage-link', [SystemController::class, 'storageLink'])->name('system.storageLink');

});

require __DIR__.'/auth.php';
