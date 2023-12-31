<?php

namespace App\Transaction\Transaction;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TransactionQuerySet
{
    public function getTenLatestTransactionsByUserForHomePage(User $user): Collection
    {
        return Transaction::with('category')
            ->baseCalculationQuery()
            ->whereUser($user)
            ->orderByTransactionDate()
            ->limit(10)
            ->get();
    }

    public function getExpendituresSumByDates(User $user, array $dates): float|int
    {
        return Transaction::whereUser($user)
            ->baseCalculationQuery()
            ->whereExpenditure()
            ->whereDate('transaction_date', '>=', Carbon::parse($dates[0])->format('Y-m-d'))
            ->whereDate('transaction_date', '<=', Carbon::parse(end($dates))->format('Y-m-d'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getExpendituresTodayTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->baseCalculationQuery()
            ->whereExpenditure()
            ->whereDate('transaction_date', today()->format('Y-m-d'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getIncomesTodayTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->baseCalculationQuery()
            ->whereIncome()
            ->whereDate('transaction_date', today()->format('Y-m-d'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getExpendituresThisWeekTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->baseCalculationQuery()
            ->whereExpenditure()
            ->whereDate('transaction_date', '>=', today()->startOfWeek()->format('Y-m-d'))
            ->whereDate('transaction_date', '<=', today()->format('Y-m-d'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }

    public function getIncomesThisWeekTotal(User $user): float|int
    {
        return Transaction::whereUser($user)
            ->baseCalculationQuery()
            ->whereIncome()
            ->whereDate('transaction_date', '>=', today()->startOfWeek()->format('Y-m-d'))
            ->whereDate('transaction_date', '<=', today()->format('Y-m-d'))
            ->sum(Transaction::CALCULATION_COLUMN);
    }
}
