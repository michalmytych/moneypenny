<?php

namespace App\Moneypenny\Transaction\Services\Analytics\ChartQueries;

use App\Moneypenny\Category\Models\Category;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\Transaction\Services\Analytics\Charts\DoughnutChart;
use App\Moneypenny\User\Models\User;

class CategorizedPercentage extends ChartQuery
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

        $totalTransactions = Transaction::whereUser($user)->baseCalculationQuery()->count();
        $totalTransactionsCategorized = $categories->sum('transactions_count');

        $labels = ['Categorized', 'Uncategorized'];
        $values = [
            $totalTransactionsCategorized,
            $totalTransactions - $totalTransactionsCategorized
        ];

        return DoughnutChart::make(
            header: 'Transactions count',
            labels: $labels,
            data: $values,
            dataBaseUrl: route('transaction.index')
        );
    }
}
