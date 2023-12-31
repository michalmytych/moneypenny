<?php

namespace App\Moneypenny\Transaction\Services\Analytics\ChartQueries;

use App\Moneypenny\Category\Models\Category;
use App\Moneypenny\Transaction\Services\Analytics\Charts\DoughnutChart;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Str;

class CategoriesPercentage extends ChartQuery
{
    public function get(User $user): array
    {
        $categories = Category::query()
            ->withCount([
                'transactions as transactions_count' => function ($query) use ($user) {
                    $query
                        ->baseCalculationQuery()
                        ->where('user_id', $user->id);
                }])
            ->get();

        $totalTransactionsCategorized = $categories->sum('transactions_count');

        $categoriesLabels = [];
        $categoriesValues = [];

        $categories
            ->each(function ($category) use ($totalTransactionsCategorized, &$categoriesLabels, &$categoriesValues) {
                $categoriesLabels[] = Str::ucfirst($category->code);
                $categoriesValues[] = $totalTransactionsCategorized ? $category->transactions_count / $totalTransactionsCategorized : 0;
            });

        return DoughnutChart::make(
            header: ' Of category',
            labels: $categoriesLabels,
            data: $categoriesValues,
            dataBaseUrl: route('transaction.index')
        );
    }
}
