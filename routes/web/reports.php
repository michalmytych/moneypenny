<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Transaction\ReportController;

Route::prefix('reports')->as('report.')->group(function () {
    Route::get('/periodic', [ReportController::class, 'periodic'])->name('periodic');
});

