<?php

use App\Http\Controllers\Web\ExchangeRates\ExchangeRateController;
use App\Http\Controllers\Web\Meta\MetaController;
use App\Http\Controllers\Web\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::prefix('users')->as('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/confirm-change-role', [UserController::class, 'confirmRoleChange'])
            ->name('confirm_change_role');
        Route::get('/{id}/confirm-block', [UserController::class, 'confirmBlock'])
            ->name('confirm_block');
        Route::get('/{id}/confirm-delete', [UserController::class, 'confirmDelete'])
            ->name('confirm_delete');
        Route::delete('/{id}/delete', [UserController::class, 'delete'])
            ->name('delete');
        Route::post('/{id}/change-role', [UserController::class, 'changeRole'])
            ->name('change_role');
        Route::post('/{id}/block', [UserController::class, 'block'])
            ->name('block');
        Route::post('/{id}/unblock', [UserController::class, 'unblock'])
            ->name('unblock');
        Route::get('/{id}', [UserController::class, 'show'])
            ->name('show');
    });

    Route::prefix('exchange-rates')->as('exchange_rate.')->group(function () {
        Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
    });

    Route::prefix('meta')->as('meta.')->group(function () {
        Route::get('/', [MetaController::class, 'index'])->name('index');
    });
});

