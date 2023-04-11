<?php

namespace App\Nordigen\Synchronization;

use App\Nordigen\DataObjects\TransactionDataObject;

interface NordigenTransactionServiceInterface
{
    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, mixed $synchronizationId);
}
