<?php

namespace App\Transaction\Categorize;

use App\Moneypenny\Category\Models\Category;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Transaction\Cache\TransactionsCache;
use Illuminate\Support\Collection;

readonly class CategorizationService
{
    public function __construct(private CacheAdapterInterface $cacheAdapter)
    {}

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
        return (boolean) $this->cacheAdapter->get(TransactionsCache::PENDING_RECATEGORIZATION);
    }

    public function getUncategorizedTransactions(): Collection
    {
        return Transaction::whereNull('category_id')->latest()->get();
    }
}
