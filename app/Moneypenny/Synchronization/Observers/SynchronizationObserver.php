<?php

namespace App\Moneypenny\Synchronization\Observers;

use App\Moneypenny\Synchronization\Models\Synchronization;
use App\Transaction\Synchronization\SynchronizationService;

readonly class SynchronizationObserver
{
    public function __construct(private SynchronizationService $synchronizationService)
    {
    }

    public function updated(Synchronization $synchronization): void
    {
        $this->synchronizationService->handleSynchronizationUpdate($synchronization);
    }
}
