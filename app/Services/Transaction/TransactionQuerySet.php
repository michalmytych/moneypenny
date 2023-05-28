<?php

namespace App\Services\Transaction;

use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;

class TransactionQuerySet
{
    public function getExpendituresSumByDates(User $user, array $dates): float|int
    {
        return Transaction::whereUser($user)
            ->whereExpenditure()
            ->whereDate('transaction_date', '>=', Carbon::parse($dates[0]))
            ->whereDate('transaction_date', '<=', Carbon::parse(end($dates)))
            ->sum(Transaction::CALCULATION_COLUMN);
    }
}
