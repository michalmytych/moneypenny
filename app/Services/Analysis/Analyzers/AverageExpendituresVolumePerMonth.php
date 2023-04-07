<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AverageExpendituresVolumePerMonth extends Analyzer
{
    protected function runQuery(): Collection
    {
        return DB::table('transactions')
            ->select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('AVG(decimal_volume) as average_volume')
            )
            ->where('raw_volume', 'LIKE', '%-%')
            ->where('description', 'NOT LIKE', '%Założenie lokaty%')
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->get();
    }

    protected function formatDataForChart($queryResult): Collection
    {
        return $queryResult;
    }
}
