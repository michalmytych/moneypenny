<?php

use App\Moneypenny\Report\Http\Controller\Web\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->as('report.')->group(function () {
    Route::get('/periodic', [ReportController::class, 'periodic'])->name('periodic');
});

