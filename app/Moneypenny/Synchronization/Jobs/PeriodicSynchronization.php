<?php

namespace App\Moneypenny\Synchronization\Jobs;

use App\Transaction\Synchronization\SynchronizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PeriodicSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SynchronizationService $synchronizationService): void
    {
        $synchronizationService->handlePeriodicSynchronization();
    }
}
