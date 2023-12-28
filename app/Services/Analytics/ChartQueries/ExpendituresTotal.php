<?php

namespace App\Services\Analytics\ChartQueries;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Services\Helpers\DateHelper;
use App\Models\Transaction\Transaction;
use App\Services\Analytics\Charts\BarChart;

class ExpendituresTotal extends ChartQuery
{
    public function get(User $user): array
    {
        $lastMonthDates = DateHelper::getLastMonthDates();

        $data = collect($lastMonthDates)->map(
            fn($dateString) => Transaction::query()
                ->baseCalculationQuery()
                ->whereUser($user)
                ->where('type', Transaction::TYPE_EXPENDITURE)
                ->whereDate('transaction_date', Carbon::parse($dateString))
                ->sum(Transaction::CALCULATION_COLUMN)
        );

        return BarChart::make(
            header: 'Expenditures total',
            labels: $lastMonthDates,
            data: $data->toArray(),
            dataBaseUrl: route('transaction.index')
        );
    }
}
