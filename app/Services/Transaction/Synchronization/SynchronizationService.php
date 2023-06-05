<?php

namespace App\Services\Transaction\Synchronization;

use App\Models\Nordigen\Requisition;
use App\Models\Notification;
use App\Models\User;
use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;

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
}
