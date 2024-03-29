<?php

namespace App\Observers\Import;

use Throwable;
use App\Models\Import\Import;
use App\Services\Transaction\Category\CategorizeTransactionService;

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
