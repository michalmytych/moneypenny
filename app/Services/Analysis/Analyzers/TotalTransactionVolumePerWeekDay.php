<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

class TotalTransactionVolumePerWeekDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::select(
            DB::raw('DAYNAME(transaction_date) as day_name'),
            DB::raw('SUM(decimal_volume) as total_volume')
        )
            ->groupBy('day_name')
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
