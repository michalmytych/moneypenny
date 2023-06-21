<?php

use App\Http\Controllers\Web\ExchangeRates\ExchangeRateController; // @todo should be in api
use Illuminate\Support\Facades\Route;

Route::prefix('exchange-rates')->as('exchange_rates.')->group(function () {
    Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
});
