<?php

namespace App\Services\Analytics\ChartQueries;

use App\Models\User;
use App\Services\Helpers\DateHelper;
use App\Services\Analytics\Charts\LinearChart;
use App\Services\Transaction\Report\ReportService;

class ExpendituresAndIncomesTrend extends ChartQuery
{
    public function __construct(private readonly ReportService $reportService)
    {
    }

    public function get(User $user): array
    {
        $lastMonthDates = DateHelper::getLastMonthDates();
        $data = $this
            ->reportService
            ->getAvgExpendituresByDays($user, sinceDate: now()->subMonth(), toDate: now());

        return LinearChart::make(
            header: 'Expenditures average trend',
            labels: $lastMonthDates,
            data: $data->pluck('total')->toArray(),
            dataBaseUrl: route('transaction.index')
        );
    }
}
