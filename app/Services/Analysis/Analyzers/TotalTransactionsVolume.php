<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use App\Models\Transaction\Transaction;

/**
 * @deprecated
 */
class TotalTransactionsVolume extends Analyzer
{
    protected function runQuery(): Collection
    {
        return collect([
            'total_volume' =>
                Transaction::where('raw_volume', 'LIKE', '%-%')
                    ->where('description', 'NOT LIKE', '%Założenie lokaty%')
                    ->sum('decimal_volume')
        ]);
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
