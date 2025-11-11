<?php

namespace App\Contracts\Services\ExchangeRates;

use Illuminate\Support\Carbon;
use App\Models\ExchangeRates\ExchangeRate;
use App\Services\ExchangeRates\DataObjects\HistoricalExchangeRateDataObject;

interface ExchangeRatesServiceInterface
{
    public function getOrCreateExchangeRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): ExchangeRate;

    public function provideNewHistoryRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): HistoricalExchangeRateDataObject;
}
