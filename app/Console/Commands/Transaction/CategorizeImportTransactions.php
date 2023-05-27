<?php

namespace App\Console\Commands\Transaction;

use Throwable;
use Illuminate\Console\Command;
use App\Services\Transaction\Category\CategorizeTransactionService;

class CategorizeImportTransactions extends Command
{
    protected $signature = 'moneypenny:categorize-import-transaction {importId}';

    protected $description = 'Trigger transactions categorization by import.';

    /**
     * @throws Throwable
     */
    public function handle(CategorizeTransactionService $categorizeTransactionService): void
    {
        $importId = $this->argument('importId');
        $categorizeTransactionService->categorizeImportTransactions($importId);
    }
}
