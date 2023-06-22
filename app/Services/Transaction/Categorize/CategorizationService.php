<?php

namespace App\Services\Transaction\Categorize;

use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use Illuminate\Support\Facades\Cache;

class CategorizationService
{
    public const PENDING_CATEGORIZATION_CACHE_KEY = 'pending_recategorization';

    /** @noinspection PhpUndefinedMethodInspection */
    public function getStats(): array
    {
        return [
            'categorized_percent' => Category::count() > 0 ? Transaction::whereNotNull('category_id')->count() / Transaction::count() : 0,
        ];
    }

    public function getRecategorizationsPending(): bool
    {
        return (boolean) Cache::get(self::PENDING_CATEGORIZATION_CACHE_KEY);
    }
}
