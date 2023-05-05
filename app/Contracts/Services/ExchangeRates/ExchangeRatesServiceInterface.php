<?php

namespace App\Contracts\Services\ExchangeRates;

use App\Models\ExchangeRates\ExchangeRate;
use App\Services\ExchangeRates\DataObjects\HistoricalExchangeRateDataObject;
use Illuminate\Support\Carbon;

interface ExchangeRatesServiceInterface
{
    public function getOrCreateExchangeRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): ExchangeRate;

    public function provideNewHistoryRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): HistoricalExchangeRateDataObject;
}
