<?php

namespace App\Contracts\Services\Transaction;

use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;

interface TransactionSyncServiceInterface
{
    public function syncTransactions(mixed $requisitionId, mixed $synchronizationId);

    public function getInstitutionByExternalId(mixed $institutionId);

    public function provideSupportedInstitutionsData();

    public function syncAccounts(mixed $requisitionId, mixed $synchronizationId): void;

    public function getAgreements(): Collection;

    public function getAgreementById(mixed $id);

    public function getAgreementsByInstitution(mixed $institutionId): Collection;

    public function createNewRequisition(mixed $institutionId, mixed $endUserAgreementId);

    public function getExistingAgreementForInstitution(mixed $institutionId);

    public function createNewUserAgreement(mixed $institutionId);

    public function setStatusSucceeded(Synchronization $synchronization);

    public function setStatusFailed(Synchronization $synchronization);
}
