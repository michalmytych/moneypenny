<?php

namespace App\Nordigen\Synchronization;

use App\Models\Import\Import;
use App\Nordigen\DataObjects\TransactionDataObject;

interface NordigenTransactionServiceInterface
{
    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, Import $import);
}
