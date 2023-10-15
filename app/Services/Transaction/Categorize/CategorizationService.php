<?php

namespace App\Services\Transaction\Categorize;

use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use Illuminate\Support\Collection;

readonly class CategorizationService
{
    public function __construct(private CacheAdapterInterface $cacheAdapter)
    {
    }

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
        return (boolean) $this->cacheAdapter->get(self::PENDING_CATEGORIZATION_CACHE_KEY);
    }

    public function getUncategorizedTransactions(): Collection
    {
        return Transaction::whereNull('category_id')->latest()->get();
    }
}
