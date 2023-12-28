<?php

namespace App\Observers\Synchronization;

use App\Models\Synchronization\Synchronization;
use App\Services\Transaction\Synchronization\SynchronizationService;

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
