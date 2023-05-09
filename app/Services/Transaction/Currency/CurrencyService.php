<?php

namespace App\Services\Transaction\Currency;

class CurrencyService
{
    // @todo should take user preference as argument
    public function resolveCalculationCurrency(): string
    {
        return 'PLN';
    }
}
