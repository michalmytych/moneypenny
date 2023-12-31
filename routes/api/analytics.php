<?php

use App\Moneypenny\Transaction\Http\Controller\Api\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::prefix('analytics')->as('analytic.')->group(function() {
    Route::get('/', [AnalyticsController::class, 'index'])->name('index');
});
