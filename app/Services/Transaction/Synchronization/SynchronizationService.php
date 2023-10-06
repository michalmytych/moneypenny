<?php

namespace App\Services\Transaction\Synchronization;

use App\Models\Import\Import;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Nordigen\Requisition;
use App\Models\Notification;
use App\Models\User;
use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;
use Illuminate\Support\Facades\Http;

class SynchronizationService
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function all(User $user): Collection
    {
        return Synchronization::whereUser($user)->latest()->get();
    }

    public function checkRequisition(User $user, mixed $agreementId): ?Requisition
    {
        $conditions = [
            'end_user_agreement_id' => $agreementId,
            'user_id' => $user->id
        ];

        $requisition = Requisition::latest()
            ->where($conditions)
            ->get()
            ->first();

        if (!$requisition) {
            abort(404);
        }

        return $requisition;
    }

    public function create(User $user): Synchronization
    {
        return Synchronization::create(['user_id' => $user->id]);
    }

    public function handleSynchronizationUpdate(Synchronization $synchronization): void
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

    public function handlePeriodicSynchronization(): void
    {
        $lastSuccessfulSync = Synchronization::query()
            ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
            ->latest()
            ->get()
            ->first();

        /** @var Carbon $carbon */
        $carbon = $lastSuccessfulSync->created_at;

        if (now()->diffInHours($carbon) > 4) {
            $agreement = EndUserAgreement::latest()->limit(1)->get()->first();

            // @todo - Run internally
            Http::post(route('api.sync', ['agreement_id' => $agreement->id]));

            $import = Import::latest()->withCount('addedTransactions')->limit(1)->get()->first();

            $this->notificationBroadcastService->sendStoredApplicationNotification(
                header: 'New automatic synchronization',
                content: "$import->added_transactions_count new transactions",
                url: route('transaction.index'),
                userId: $agreement->user_id,
                type: Notification::TYPE_EVENT
            );
        }
    }
}
