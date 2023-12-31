<?php

namespace App\Nordigen\Services;

use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\User\Models\User;
use App\Nordigen\DataObjects\TransactionDataObject;

interface NordigenTransactionServiceInterface
{
    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, Import $import, User $user);
}
