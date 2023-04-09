<?php

namespace App\Contracts\Services\Transaction;

interface TransactionSyncServiceInterface
{
    public function getNewTransactions();

    public function getInstitutionByExternalId(mixed $institutionId);

    public function provideSupportedInstitutionsData();

    public function getExistingAgreementForInstitution(mixed $institutionId);

    public function createNewUserAgreement(mixed $institutionId);
}
