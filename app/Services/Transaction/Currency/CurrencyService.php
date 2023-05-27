<?php

namespace App\Services\Transaction\Currency;

use App\Models\User;

class CurrencyService
{
    public function resolveCalculationCurrency(?User $user = null): string
    {
        return $user?->settings->base_currency_code ?? config('moneypenny.base_calculation_currency');
    }
}
