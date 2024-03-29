<?php

namespace App\Contracts\Services\Transaction;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;

interface TransactionSyncServiceInterface
{
    public function syncTransactions(mixed $requisitionId, mixed $synchronizationId, User $user);

    public function getInstitutionByExternalId(mixed $institutionId);

    public function provideSupportedInstitutionsData();

    public function syncAccounts(mixed $requisitionId, mixed $synchronizationId, User $user): void;

    public function getAgreements(User $user): Collection;

    public function getAgreementById(User $user, mixed $id);

    public function getAgreementsByInstitution(User $user, mixed $institutionId): Collection;

    public function createNewRequisition(mixed $institutionId, mixed $endUserAgreementId, User $user);

    public function getExistingAgreementForInstitution(User $user, mixed $institutionId);

    public function createNewUserAgreement(User $user, mixed $institutionId);

    public function setStatusSucceeded(Synchronization $synchronization);

    public function setStatusFailed(Synchronization $synchronization, ?int $status = null);
}
