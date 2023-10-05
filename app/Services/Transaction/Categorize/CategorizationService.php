<?php

namespace App\Services\Transaction\Categorize;

use Illuminate\Support\Collection;
use App\Models\Transaction\Category;
use Illuminate\Support\Facades\Cache;
use App\Models\Transaction\Transaction;

class CategorizationService
{
    public const PENDING_CATEGORIZATION_CACHE_KEY = 'pending_recategorization';

    /** @noinspection PhpUndefinedMethodInspection */
    public function getStats(): array
    {
        $categorizedPercentage = 0;
        $allTransactionsCount = Transaction::count();

        if ($allTransactionsCount > 0) {
            $categorizedPercentage = Category::count() > 0
                ? Transaction::whereNotNull('category_id')->count() / $allTransactionsCount
                : 0;
        }

        return [
            'categorized_percent' => $categorizedPercentage,
        ];
    }

    public function getRecategorizationsPending(): bool
    {
        return (boolean) Cache::get(self::PENDING_CATEGORIZATION_CACHE_KEY);
    }

    public function getUncategorizedTransactions(): Collection
    {
        return Transaction::whereNull('category_id')->latest()->get();
    }
}
