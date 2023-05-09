<?php

namespace App\Services\Transaction\Traits;

use App\Models\Transaction\Transaction;

trait FindsSimilarTransaction
{
    protected function similarTransactionExists(array $attributes): bool
    {
        return Transaction::query()
            ->whereDate('transaction_date', $attributes['transaction_date'])
            ->where('description', 'LIKE', '%' . $attributes['description'] . '%')
            ->where('decimal_volume', $attributes['decimal_volume'])
            ->exists();
    }
}
