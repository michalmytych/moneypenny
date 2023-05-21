<?php

namespace App\Services\HomePage;

use App\Models\User;
use App\Models\Transaction\Transaction;
use App\Models\Synchronization\Synchronization;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class HomePageService
{
    public function __construct(private readonly TransactionSyncServiceInterface $transactionSyncService)
    {
    }

    public function getLatestTransactionsData(User $user): array
    {
        return [
            'agreement' => $this
                ->transactionSyncService
                ->getAgreements($user)
                ->first(),
            'transactions' => Transaction::whereUser($user)
                ->orderByTransactionDate()
                ->limit(5)
                ->get(),
            'last_synchronization' => Synchronization::whereUser($user)
                ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
                ->with('import')
                ->latest()
                ->limit(1)
                ->get()
                ->first()
        ];
    }
}
