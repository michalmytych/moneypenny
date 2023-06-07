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

    public function getExpendituresTodayTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->whereExpenditure()
            ->whereDate('transaction_date', now()->format('d-m-Y'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getIncomesTodayTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->whereIncome()
            ->whereDate('transaction_date', now()->format('d-m-Y'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getExpendituresThisWeekTotal(User $user): float|int
    {
        $now = now();
        return Transaction::whereUser($user)
            ->whereExpenditure()
            ->whereDate('transaction_date', '>=', $now->subDays($now->dayOfWeek - 1))
            ->whereDate('transaction_date', '<=', $now)
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getIncomesThisWeekTotal(User $user): float|int
    {
        $now = now();
        return Transaction::whereUser($user)
            ->whereIncome()
            ->whereDate('transaction_date', '>=', $now->subDays($now->dayOfWeek - 1))
            ->whereDate('transaction_date', '<=', $now)
            ->sum(Transaction::CALCULATION_COLUMN);
    }
}
