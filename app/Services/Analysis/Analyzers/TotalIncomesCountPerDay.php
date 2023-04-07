<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

class TotalIncomesCountPerDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::select('transaction_date', DB::raw('COUNT(*) as total_incomes_count'))
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
