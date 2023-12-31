<?php

namespace App\ExchangeRates\Contracts;

use App\ExchangeRates\DataObjects\HistoricalExchangeRateDataObject;
use App\ExchangeRates\Models\ExchangeRate;
use Illuminate\Support\Carbon;

interface ExchangeRatesServiceInterface
{
    public function getOrCreateExchangeRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): ExchangeRate;

    public function provideNewHistoryRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): HistoricalExchangeRateDataObject;
}
