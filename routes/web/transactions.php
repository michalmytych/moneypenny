<?php

use App\Http\Controllers\Web\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')->as('transaction.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'create'])->name('create');
    Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
    Route::patch('/{id}', [TransactionController::class, 'patch'])->name('patch');
});
