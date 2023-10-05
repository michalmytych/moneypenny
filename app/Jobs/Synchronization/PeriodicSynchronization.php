<?php

namespace App\Jobs\Synchronization;

use App\Models\Notification;
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
        $lastSuccessfulSync = Synchronization::query()
            ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
            ->latest()
            ->get()
            ->first();

        /** @var Carbon $c */
        $c = $lastSuccessfulSync->created_at;

        if (now()->diffInHours($c) > 4) {
            // @todo refactor
            $agreement = EndUserAgreement::latest()->limit(1)->get()->first();

            Http::post(route('api.sync', ['agreement_id' => $agreement->id]));

            $import = Import::latest()->withCount('addedTransactions')->limit(1)->get()->first();

            $notificationBroadcastService->sendStoredApplicationNotification(
                header: 'New automatic synchronization',
                content: "$import->added_transactions_count new transactions",
                url: route('transaction.index'),
                userId: $agreement->user_id,
                type: Notification::TYPE_EVENT
            );
        }
    }
}
