<?php

use App\Moneypenny\Transaction\Http\Controller\Web\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')->as('transaction.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'create'])->name('create');
    Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
    Route::patch('/{id}', [TransactionController::class, 'patch'])->name('patch');
    Route::post('/{id}/toggle-exclude-from-calculation', [TransactionController::class, 'toggleExcludeFromCalculation'])->name('toggle_exclude_from_calculation');
});
