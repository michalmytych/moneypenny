<?php

namespace App\Console\Commands\Transaction;

use Throwable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Services\Helpers\StringHelper;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\Category\CategorizeTransactionService;

class CategorizeAllTransactionsDebug extends Command
{
    protected $signature = 'moneypenny:categorize-all-transactions-debug
                            {?--only-uncategorized : Whether only uncategorized transactions should be taken into account.}';

    protected $description = 'Categorize all transactions with debug info.';

    public function handle(CategorizeTransactionService $categorizeTransactionService): void
    {
        $chunkSize = 100;
        $transactionBaseQuery = Transaction::query();
        $transactionsTotalCount = Transaction::count();
        $selectedToCategorizationCount = $transactionsTotalCount;

        if ($this->hasOption('only-uncategorized')) {
            $transactionBaseQuery = Transaction::whereNull('category_id');
            $selectedToCategorizationCount = (clone $transactionBaseQuery)->count();
        }

        $transactionsChunksCount = round($selectedToCategorizationCount / $chunkSize);

        $this->info('Categorizing ' . $selectedToCategorizationCount . ' transactions...');
        $this->line($transactionsChunksCount . ' chunks to go.');

        $chunkCounter = 0;
        $transactionBaseQuery
            ->chunk($chunkSize, function (Collection $transactions) use ($categorizeTransactionService, &$chunkCounter) {
                try {
                    $categorizedPercentage = $categorizeTransactionService->categorizeTransactionsSync($transactions);
                    ++$chunkCounter;
                    $categorizedFormatted = number_format($categorizedPercentage * 100, 1);
                    $line = '[' . $chunkCounter . '] Processed chunk. ' . $categorizedFormatted . '% categorized.';
                    $this->line($line);

                } catch (Throwable $throwable) {
                    $this->error('[' . $chunkCounter . '] Processed chunk failed');
                    $shortMessage = StringHelper::shortenAuto($throwable->getMessage(), 200);
                    $this->warn($shortMessage);
                }
            });

        /** @noinspection PhpUndefinedMethodInspection */
        $categorizedTransactionsCount = Transaction::whereNotNull('category_id')->count();
        $totalCategorizedPercentage = number_format(
            ($categorizedTransactionsCount / $transactionsTotalCount) * 100,
            1
        );

        $this->info(
            'Finished categorization. '
            . $totalCategorizedPercentage
            . '% of all transactions is assigned to some category.'
        );
    }
}
