<?php

namespace App\Services\Analytics\ChartQueries;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Transaction\Category;
use App\Services\Analytics\Charts\DoughnutChart;

class CategoriesPercentage extends ChartQuery
{
    public function get(User $user): array
    {
        $categories = Category::query()
            ->withCount(
                [
                'transactions as transactions_count' => function ($query) use ($user) {
                    $query
                        ->baseCalculationQuery()
                        ->where('user_id', $user->id);
                }]
            )
            ->get();

        $totalTransactionsCategorized = $categories->sum('transactions_count');

        $categoriesLabels = [];
        $categoriesValues = [];

        $categories
            ->each(
                function ($category) use ($totalTransactionsCategorized, &$categoriesLabels, &$categoriesValues) {
                    $categoriesLabels[] = Str::ucfirst($category->code);
                    $categoriesValues[] = $totalTransactionsCategorized ? $category->transactions_count / $totalTransactionsCategorized : 0;
                }
            );

        return DoughnutChart::make(
            header: ' Of category',
            labels: $categoriesLabels,
            data: $categoriesValues,
            dataBaseUrl: route('transaction.index')
        );
    }
}
