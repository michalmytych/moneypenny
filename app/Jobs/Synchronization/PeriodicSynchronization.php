<?php

namespace App\Jobs\Synchronization;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Transaction\Synchronization\SynchronizationService;

class PeriodicSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SynchronizationService $synchronizationService): void
    {
        $synchronizationService->handlePeriodicSynchronization();
    }
}
