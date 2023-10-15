<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ExchangeRates\ExchangeRateController;

Route::prefix('exchange-rates')->as('exchange_rate.')->group(function () {
    Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
});
