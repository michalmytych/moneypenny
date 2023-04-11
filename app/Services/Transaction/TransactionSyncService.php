<?php

namespace App\Services\Transaction;

use Carbon\Carbon;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use App\Nordigen\DataObjects\TransactionDataObject;
use App\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class TransactionSyncService implements NordigenTransactionServiceInterface
{
    public function __construct(private TransactionImportService $transactionImportService) { }

    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, mixed $synchronizationId)
    {
        $attributes = [
            'sender'             => $transactionDataObject->debtorName,
            'receiver'           => null,
            'currency'           => $transactionDataObject->currency,
            'raw_volume'         => TransactionHelper::changeComaToDotAtRawVolume($transactionDataObject->rawVolume),
            'import_id'          => null,
            'synchronization_id' => $synchronizationId,
            'description'        => $transactionDataObject->remittanceInformationUnstructured,
            'accounting_date'    => Carbon::parse($transactionDataObject->bookingDate),
            'transaction_date'   => Carbon::parse($transactionDataObject->valueDate),
            'decimal_volume'     => TransactionHelper::rawVolumeToDecimal($transactionDataObject->rawVolume),
        ];

        $similarExists = $this->transactionImportService->similarTransactionExists($attributes);

        if (!$similarExists) {
            Transaction::create($attributes);
        }
    }
}
