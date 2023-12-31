<?php

namespace App\Moneypenny\Import\Observers;

use App\Moneypenny\Import\Models\Import;
use App\Transaction\Category\CategorizeTransactionService;
use Throwable;

readonly class ImportObserver
{
    public function __construct(private CategorizeTransactionService $categorizeTransactionService) {}

    /**
     * @throws Throwable
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function created(Import $import)
    {
        $this->categorizeTransactionService->categorizeImportTransactions($import->id);
    }
}
