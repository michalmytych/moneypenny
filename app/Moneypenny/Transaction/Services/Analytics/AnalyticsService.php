<?php

namespace App\Moneypenny\Transaction\Services\Analytics;

use App\Moneypenny\Transaction\Services\Analytics\ChartQueries\CategoriesPercentage;
use App\Moneypenny\Transaction\Services\Analytics\ChartQueries\CategorizedPercentage;
use App\Moneypenny\Transaction\Services\Analytics\ChartQueries\ChartQuery;
use App\Moneypenny\Transaction\Services\Analytics\ChartQueries\ExpendituresAndIncomesTrend;
use App\Moneypenny\Transaction\Services\Analytics\ChartQueries\ExpendituresTotal;
use App\Moneypenny\User\Models\User;

class AnalyticsService
{
    public function getChartData(User $user, string $chartQueryId): array
    {
        $chartQueryClass = match ($chartQueryId) {
            'lastMonthExpenditures' => ExpendituresTotal::class,
            'categorizedPercentage' => CategorizedPercentage::class,
            'categoriesPercentage' => CategoriesPercentage::class,
            'expendituresAndIncomesTrend' => ExpendituresAndIncomesTrend::class
        };

        /** @var ChartQuery $chartQuery */
        $chartQuery = app($chartQueryClass);
        return $chartQuery->get($user);
    }
}
