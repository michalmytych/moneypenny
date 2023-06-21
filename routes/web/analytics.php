<?php

use App\Http\Controllers\Web\Transaction\Analytics\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::prefix('analytics')->as('analytic.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('index');
});

