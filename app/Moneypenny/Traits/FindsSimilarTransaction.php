<?php

namespace App\Transaction\Traits;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;

trait FindsSimilarTransaction
{
    protected function similarTransactionExists(User $user, array $attributes): bool
    {
        return Transaction::query()
            ->baseCalculationQuery()
            ->whereUser($user)
            ->whereDate('transaction_date', $attributes['transaction_date'])
            ->where('description', 'LIKE', '%' . $attributes['description'] . '%')
            ->where('decimal_volume', $attributes['decimal_volume'])
            ->exists();
    }
}
