<?php

namespace App\Transaction\Category;

use App\Moneypenny\Category\Events\ImportCategorizationFinished;
use App\Moneypenny\Transaction\Jobs\CategorizeTransactions;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\Categorize\TransactionCategorizeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\LazyCollection;
use Throwable;

class CategorizeTransactionService
{
    public function __construct(private readonly TransactionCategorizeService $transactionCategorizeService) {}

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
