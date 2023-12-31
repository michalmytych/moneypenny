<?php

namespace App\Transaction\Transaction;

use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use App\Nordigen\DataObjects\TransactionDataObject;
use App\Nordigen\Services\NordigenTransactionServiceInterface;
use App\Shared\Helpers\TransactionHelper;
use App\Transaction\Traits\DecidesTransactionType;
use App\Transaction\Traits\FindsSimilarTransaction;
use Carbon\Carbon;

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
            'decimal_volume' => TransactionHelper::rawVolumeToDecimal($transactionDataObject->rawVolume),
            'accounting_date' => Carbon::parse($transactionDataObject->bookingDate),
            'transaction_date' => Carbon::parse($transactionDataObject->valueDate),
            'personal_account_id' => $transactionDataObject->personalAccountId, // @todo - It's not being saved
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
