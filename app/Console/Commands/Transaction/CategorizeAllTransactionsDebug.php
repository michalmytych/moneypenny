<?php

namespace App\Console\Commands\Transaction;

use App\Models\Transaction\Transaction;
use App\Services\Helpers\StringHelper;
use Illuminate\Console\Command;
use App\Services\Transaction\Category\CategorizeTransactionService;
use Illuminate\Support\Collection;
use Throwable;

class CategorizeAllTransactionsDebug extends Command
{
    protected $signature = 'moneypenny:categorize-all-transactions-debug';

    protected $description = 'Categorize all transactions with debug info.';

    public function handle(CategorizeTransactionService $categorizeTransactionService): void
    {
        $chunkSize = 100;
        $transactionsTotalCount = Transaction::count();
        $transactionsChunksCount = round($transactionsTotalCount / $chunkSize);

        $this->info('Categorizing ' . $transactionsTotalCount . ' transactions...');
        $this->line($transactionsChunksCount . ' chunks to go.');

        $chunkCounter = 0;
        Transaction::chunk($chunkSize, function(Collection $transactions) use ($categorizeTransactionService, &$chunkCounter) {
            try {
                $categorizeTransactionService->categorizeTransactionsSync($transactions);
                ++$chunkCounter;
                $this->line('[' . $chunkCounter . '] Processed chunk');

            } catch (Throwable $throwable) {
                $this->error('[' . $chunkCounter . '] Processed chunk failed');
                $shortMessage = StringHelper::shortenAuto($throwable->getMessage(), 100);
                $this->warn($shortMessage);
            }
        });
    }
}
