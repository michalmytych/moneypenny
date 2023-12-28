<?php

namespace App\Services\Transaction\Category;

use App\Services\Transaction\Categorize\TransactionCategorizeService;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Throwable;
use Illuminate\Support\Facades\Bus;
use App\Models\Transaction\Transaction;
use App\Jobs\Transaction\CategorizeTransactions;
use App\Events\Transaction\Category\ImportCategorizationFinished;

class CategorizeTransactionService
{
    public function __construct(private readonly TransactionCategorizeService $transactionCategorizeService)
    {
    }

    public function categorizeTransactionsSync(Collection|LazyCollection|array $transactions): float|int
    {
        // @todo what about memory?
        return $this->transactionCategorizeService->categorizeTransactions($transactions);
    }

    /**
     * @throws Throwable
     */
    public function categorizeImportTransactions(mixed $importId): void
    {
        $categorizationJobs = [];

        Transaction::query()
            ->select('id')
            ->where('import_id', $importId)
            ->chunk(
                100, function ($transactionsChunk) use (&$categorizationJobs) {
                    $transactionsIds = collect($transactionsChunk)
                        ->pluck('id')
                        ->toArray();

                    $categorizationJobs[] = new CategorizeTransactions($transactionsIds);
                }
            );

        // @todo seems like there is not enough chunks generated (only few transactions are being sent)
        Bus::batch($categorizationJobs)
            ->name('Import [' . $importId . '] transactions categorization')
            ->finally(
                function () use ($importId) {
                    event(new ImportCategorizationFinished($importId));
                }
            )
            ->dispatch();
    }
}
