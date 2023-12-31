<?php

use App\Moneypenny\Transaction\Http\Controller\Api\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->as('report.')->group(function () {
    Route::get('avg-expenditures', [ReportController::class, 'avgExpenditures'])
        ->name('avg_expenditures');
    Route::get('avg-incomes', [ReportController::class, 'avgIncomes'])
        ->name('avg_incomes');
});
