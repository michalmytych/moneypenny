<?php

use App\Http\Controllers\Web\Transaction\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('budgets')->as('budget.')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('index');
    Route::get('/new', [BudgetController::class, 'new'])->name('new');
    Route::get('/{id}', [BudgetController::class, 'show'])->name('show');
    Route::post('/', [BudgetController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [BudgetController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [BudgetController::class, 'patch'])->name('patch');
});
