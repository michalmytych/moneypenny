<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @deprecated
 */
class TotalExpendituresVolumePerYearMonth extends Analyzer
{
    protected function runQuery(): Collection
    {
        return DB::table('transactions')
            ->select(
                DB::raw('MONTHNAME(transaction_date) as month'),
                DB::raw('SUM(decimal_volume) as total_volume')
            )
            ->whereRaw("raw_volume LIKE '%-%'")
            ->where('description', 'NOT LIKE', '%Założenie lokaty%')
            ->groupBy('month')
            ->orderByRaw("MONTH(transaction_date)")
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
