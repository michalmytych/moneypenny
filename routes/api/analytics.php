<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Transaction\Analytics\AnalyticsController;

Route::prefix('analytics')->as('analytic.')->group(function() {
    Route::get('/', [AnalyticsController::class, 'index'])->name('index');
});
