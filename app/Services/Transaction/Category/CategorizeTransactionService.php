<?php

namespace App\Services\Transaction\Category;

use Throwable;
use Illuminate\Support\Facades\Bus;
use App\Models\Transaction\Transaction;
use App\Jobs\Transaction\CategorizeTransactions;
use App\Events\Transaction\Category\ImportCategorizationFinished;

class CategorizeTransactionService
{
    public function __construct() {}

    /**
     * @throws Throwable
     */
    public function categorizeImportTransactions(mixed $importId): void
    {
        $categorizationJobs = [];

        Transaction::query()
            ->select('id')
            ->where('import_id', $importId)
            ->chunk(100, function ($transactionsChunk) use (&$categorizationJobs) {
                $transactionsIds = collect($transactionsChunk)
                    ->pluck('id')
                    ->toArray();

                $categorizationJobs[] = new CategorizeTransactions($transactionsIds);
            });

        // @todo seems like there is not enough chunks generated (only few transactions are being sent)
        Bus::batch($categorizationJobs)
            ->name('Import [' . $importId . '] transactions categorization')
            ->finally(function () use ($importId) {
                event(new ImportCategorizationFinished($importId));
            })
            ->dispatch();
    }
}
