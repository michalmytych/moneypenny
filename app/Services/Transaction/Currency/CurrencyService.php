<?php

namespace App\Services\Transaction\Currency;

use App\Models\User;

class CurrencyService
{
    // @todo should take user preference as argument
    public function resolveCalculationCurrency(?User $user = null): string
    {
        return 'PLN';
    }
}
