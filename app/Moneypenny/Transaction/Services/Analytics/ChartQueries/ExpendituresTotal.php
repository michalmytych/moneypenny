<?php

namespace App\Moneypenny\Transaction\Services\Analytics\ChartQueries;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\Transaction\Services\Analytics\Charts\BarChart;
use App\Moneypenny\User\Models\User;
use App\Shared\Helpers\DateHelper;
use Illuminate\Support\Carbon;

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
