<?php

namespace App\Services\Transaction;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Import\Import;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use App\Services\Transaction\Traits\DecidesTransactionType;
use App\Services\Nordigen\DataObjects\TransactionDataObject;
use App\Services\Transaction\Traits\FindsSimilarTransaction;
use App\Services\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class TransactionSyncService implements NordigenTransactionServiceInterface
{
    use FindsSimilarTransaction, DecidesTransactionType;

    public function __construct(private readonly TransactionImportService $transactionImportService)
    {
    }

    public function addNewSynchronizedTransaction(TransactionDataObject $transactionDataObject, Import $import, User $user): ?Transaction
    {
        $attributes = [
            'user_id' => $user->id,
            'type' => $this->decideTransactionTypeByRawVolume($transactionDataObject->rawVolume),
            'sender' => $transactionDataObject->debtorName,
            'receiver' => $transactionDataObject->creditorName,
            'currency' => $transactionDataObject->currency,
            'raw_volume' => TransactionHelper::changeComaToDotAtRawVolume($transactionDataObject->rawVolume),
            'import_id' => $import->id,
            'description' => $transactionDataObject->remittanceInformationUnstructured,
            'accounting_date' => Carbon::parse($transactionDataObject->bookingDate),
            'transaction_date' => Carbon::parse($transactionDataObject->valueDate),
            'decimal_volume' => TransactionHelper::rawVolumeToDecimal($transactionDataObject->rawVolume),
            'calculation_volume' => TransactionHelper::rawVolumeToDecimal($transactionDataObject->rawVolume),
            'sender_account_number' => $transactionDataObject->senderAccountNumber,
            'receiver_account_number' => $transactionDataObject->receiverAccountNumber,
        ];

        $similarExists = $this->similarTransactionExists($user, $attributes);

        if (!$similarExists) {
            return Transaction::create($attributes);
        }

        $import->update(['transactions_skipped_count' => $import->transactions_skipped_count + 1]);

        return null;
    }
}
