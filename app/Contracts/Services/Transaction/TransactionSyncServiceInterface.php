<?php

namespace App\Contracts\Services\Transaction;

use Illuminate\Support\Collection;

interface TransactionSyncServiceInterface
{
    public function getNewTransactions();

    public function getInstitutionByExternalId(mixed $institutionId);

    public function provideSupportedInstitutionsData();

    public function getAgreements(): Collection;

    public function getAgreementById(mixed $id);

    public function getAgreementsByInstitution(mixed $institutionId): Collection;

    public function createNewRequisition(mixed $institutionId, mixed $endUserAgreementId);

    public function getExistingAgreementForInstitution(mixed $institutionId);

    public function createNewUserAgreement(mixed $institutionId);
}
