<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

class TransactionCountPerDay extends Analyzer
{
    protected function runQuery(): Collection
    {
        return Transaction::select('transaction_date', DB::raw('COUNT(*) as total_transactions'))
            ->groupBy('transaction_date')
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
