<?php

namespace App\Services\Transaction;

use App\Models\Import\Import;
use Carbon\Carbon;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use App\Nordigen\DataObjects\TransactionDataObject;
use App\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class TransactionSyncService implements NordigenTransactionServiceInterface
{
    public function __construct(private readonly TransactionImportService $transactionImportService) { }

    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, Import $import): ?Transaction
    {
        $attributes = [
            'sender'             => $transactionDataObject->debtorName,
            'receiver'           => null,
            'currency'           => $transactionDataObject->currency,
            'raw_volume'         => TransactionHelper::changeComaToDotAtRawVolume($transactionDataObject->rawVolume),
            'import_id'          => $import->id,
            'description'        => $transactionDataObject->remittanceInformationUnstructured,
            'accounting_date'    => Carbon::parse($transactionDataObject->bookingDate),
            'transaction_date'   => Carbon::parse($transactionDataObject->valueDate),
            'decimal_volume'     => TransactionHelper::rawVolumeToDecimal($transactionDataObject->rawVolume),
        ];

        $similarExists = $this->transactionImportService->similarTransactionExists($attributes);

        if (!$similarExists) {
            return Transaction::create($attributes);
        }

        $import->update(['transactions_skipped_count' => $import->transactions_skipped_count + 1 ]);

        return null;
    }
}
