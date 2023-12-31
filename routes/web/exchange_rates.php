<?php

use App\ExchangeRates\Http\Controller\Web\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::prefix('exchange-rates')->as('exchange_rate.')->group(function () {
    Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
});
