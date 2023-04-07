<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

class TotalExpendituresCountPerDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::query()
            ->select('transaction_date', DB::raw('COUNT(*) as total_expenditures_count'))
            ->where('raw_volume', 'LIKE', '%-%')
            ->where('description', 'NOT LIKE', '%Założenie lokaty%')
            ->orderBy('transaction_date')
            ->groupBy('transaction_date')
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
