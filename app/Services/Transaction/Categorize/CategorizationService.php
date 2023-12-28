<?php

namespace App\Services\Transaction\Categorize;

use Illuminate\Support\Collection;
use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\Cache\TransactionsCache;
use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;

readonly class CategorizationService
{
    public function __construct(private CacheAdapterInterface $cacheAdapter)
    {
    }

    /**
     * @noinspection PhpUndefinedMethodInspection 
     */
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
        return (boolean) $this->cacheAdapter->get(TransactionsCache::PENDING_RECATEGORIZATION);
    }

    public function getUncategorizedTransactions(): Collection
    {
        return Transaction::whereNull('category_id')->latest()->get();
    }
}
