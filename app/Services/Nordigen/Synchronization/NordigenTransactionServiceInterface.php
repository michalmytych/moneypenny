<?php

namespace App\Services\Nordigen\Synchronization;

use App\Models\Import\Import;
use App\Services\Nordigen\DataObjects\TransactionDataObject;

interface NordigenTransactionServiceInterface
{
    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, Import $import);
}
