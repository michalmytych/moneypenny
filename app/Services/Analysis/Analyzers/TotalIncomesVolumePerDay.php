<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

/**
 * @deprecated
 */
class TotalIncomesVolumePerDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::query()
            ->select('transaction_date', DB::raw('SUM(decimal_volume) as total_incomes_volume'))
            ->where('raw_volume', 'NOT LIKE', '%-%')
            ->orderBy('transaction_date')
            ->groupBy('transaction_date')
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
