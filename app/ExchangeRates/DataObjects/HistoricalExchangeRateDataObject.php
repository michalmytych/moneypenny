<?php

namespace App\ExchangeRates\DataObjects;

use Illuminate\Support\Carbon;

class HistoricalExchangeRateDataObject extends DataObject
{
    public function __construct(
        public Carbon $date,
        public string $rate,
        public string $baseCurrencyCode,
        public string $targetCurrencyCode,
    ) {}

    public static function make(mixed $data): DataObject
    {
        return new self(
            date: data_get($data, 'date'),
            rate: data_get($data, 'rate'),
            baseCurrencyCode: data_get($data, 'base_currency_code'),
            targetCurrencyCode: data_get($data, 'target_currency_code')
        );
    }
}
