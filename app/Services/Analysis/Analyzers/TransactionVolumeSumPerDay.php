<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

/**
 * @deprecated
 */
class TransactionVolumeSumPerDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::select('transaction_date', DB::raw('SUM(decimal_volume) as total_volume'))
            ->groupBy('transaction_date')
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
