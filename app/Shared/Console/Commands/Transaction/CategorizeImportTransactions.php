<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Transaction\Category\CategorizeTransactionService;
use Illuminate\Console\Command;
use Throwable;

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
