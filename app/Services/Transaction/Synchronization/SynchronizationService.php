<?php

namespace App\Services\Transaction\Synchronization;

use App\Models\Nordigen\Requisition;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;

class SynchronizationService
{
    public function all(User $user): Collection
    {
        return Synchronization::whereUser($user)->latest()->get();
    }

    public function checkRequisition(User $user, mixed $agreementId): ?Requisition
    {
        $requisition = Requisition::latest()->firstWhere([
            'end_user_agreement_id' => $agreementId,
            'user_id' => $user->id
        ]);

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
