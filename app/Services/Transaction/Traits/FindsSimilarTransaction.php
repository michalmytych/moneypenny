<?php

namespace App\Services\Transaction\Traits;

use App\Models\Transaction\Transaction;
use App\Models\User;

trait FindsSimilarTransaction
{
    protected function similarTransactionExists(User $user, array $attributes): bool
    {
        return Transaction::query()
            ->whereUser($user)
            ->whereDate('transaction_date', $attributes['transaction_date'])
            ->where('description', 'LIKE', '%' . $attributes['description'] . '%')
            ->where('decimal_volume', $attributes['decimal_volume'])
            ->exists();
    }
}
