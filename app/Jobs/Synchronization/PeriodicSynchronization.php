<?php

namespace App\Jobs\Synchronization;

use Illuminate\Bus\Queueable;
use App\Models\Import\Import;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Nordigen\EndUserAgreement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Synchronization\Synchronization;
use App\Services\Notification\Broadcast\NotificationBroadcastService;

class PeriodicSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(NotificationBroadcastService $notificationBroadcastService): void
    {
        $lastSuccesfullSync = Synchronization::query()
            ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
            ->latest()
            ->get()
            ->first();

        /** @var Carbon $c */
        $c = $lastSuccesfullSync->created_at;

        if (now()->diffInHours($c) > 4) {
            // @todo refactor
            $agreement = EndUserAgreement::latest()->limit(1)->get()->first();

            Http::post(route('api.sync', ['agreement_id' => $agreement->id]));

            $import = Import::latest()->withCount('addedTransactions')->limit(1)->get()->first();

            $notificationBroadcastService->sendStoredApplicationNotification(
                header: 'Nowa automatyczna synchronizacja',
                content: "$import->added_transactions_count nowych transakcji",
                url: route('transaction.index')
            );
        }
    }
}
