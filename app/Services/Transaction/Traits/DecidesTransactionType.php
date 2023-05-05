<?php

namespace App\Services\Transaction\Traits;

use App\Models\Transaction\Transaction;

trait DecidesTransactionType
{
    protected function decideTransactionTypeByRawVolume(string $rawVolume): int
    {
        if (str_starts_with($rawVolume, '-')) {
            return Transaction::TYPE_EXPENDITURE;
        }

        return Transaction::TYPE_INCOME;
    }
}
