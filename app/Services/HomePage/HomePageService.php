<?php

namespace App\Services\HomePage;

use App\Models\Transaction\Transaction;
use App\Models\Synchronization\Synchronization;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class HomePageService
{
    public function __construct(private readonly TransactionSyncServiceInterface $transactionSyncService)
    {
    }

    public function getLatestTransactionsData(): array
    {
        return [
            'agreement' => $this
                ->transactionSyncService
                ->getAgreements()
                ->first(),
            'transactions' => Transaction::orderByTransactionDate()
                ->limit(5)
                ->get(),
            'last_synchronization' => Synchronization::query()
                ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
                ->with('import')
                ->latest()
                ->limit(1)
                ->get()
                ->first()
        ];
    }
}
