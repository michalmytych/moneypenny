<?php

namespace App\Services\Analytics;

use App\Models\User;
use App\Services\Analytics\ChartQueries\ChartQuery;
use App\Services\Analytics\ChartQueries\ExpendituresTotal;
use App\Services\Analytics\ChartQueries\CategoriesPercentage;
use App\Services\Analytics\ChartQueries\CategorizedPercentage;
use App\Services\Analytics\ChartQueries\ExpendituresAndIncomesTrend;

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
