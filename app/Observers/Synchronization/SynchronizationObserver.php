<?php

namespace App\Observers\Synchronization;

use App\Models\Import\Import;
use App\Models\Notification;
use App\Models\Synchronization\Synchronization;
use App\Services\Notification\Broadcast\NotificationBroadcastService;

class SynchronizationObserver
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService)
    {
    }

    public function updated(Synchronization $synchronization): void
    {
        if ($synchronization->status === Synchronization::SYNC_STATUS_SUCCEEDED) {
            $import = Import::where('synchronization_id', $synchronization->id)->get()->first();    // @todo - to service
            $importTransactionsCount = $import ? $import->addedTransactions()->count() : 0;

            $this->notificationBroadcastService->sendStoredApplicationNotification(
                header: 'New transactions synchronization! ',
                content: $importTransactionsCount . ' transactions added',
                url: route('transaction.index'),
                userId: $synchronization->user->id,
                type: Notification::TYPE_EVENT
            );
        }

        if ($synchronization->status === Synchronization::SYNC_STATUS_FAILED) {
            $header = 'Synchronization failed';

            if ($synchronization->code === 429) {
                $header = 'Daily synchronizations limit exceeded';
            }

            $this->notificationBroadcastService->sendStoredApplicationNotification(
                header: $header,
                content: 'Application will automatically synchronize tomorrow',
                url: route('home'),
                userId: $synchronization->user->id,
                type: Notification::TYPE_EVENT
            );
        }
    }
}
