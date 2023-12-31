<?php

namespace App\Transaction\Transaction;

use App\Moneypenny\Import\Models\ColumnsMapping;
use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use App\Shared\Helpers\TransactionHelper;
use App\Transaction\Traits\DecidesTransactionType;
use App\Transaction\Traits\FindsSimilarTransaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransactionImportService
{
    use FindsSimilarTransaction, DecidesTransactionType;

    public function importFileRowAsTransaction(Collection $row, Import $import, ColumnsMapping $columnsMapping, User $user): ?Transaction
    {
        $sender = data_get($row, $columnsMapping->sender_column_index);
        $rawVolume = data_get($row, $columnsMapping->volume_column_index);
        $receiver = data_get($row, $columnsMapping->receiver_column_index);
        $currency = data_get($row, $columnsMapping->currency_column_index);
        $description = data_get($row, $columnsMapping->description_column_index);
        $accountingDate = data_get($row, $columnsMapping->accounting_date_column_index);
        $transactionDate = data_get($row, $columnsMapping->transaction_date_column_index);
        $senderAccountNumber = data_get($row, $columnsMapping->sender_account_number_column_index);
        $receiverAccountNumber = data_get($row, $columnsMapping->receiver_account_number_column_index);

        $attributes = [
            'sender' => $sender,
            'user_id' => $user->id,
            'receiver' => $receiver,
            'currency' => $currency,
            'raw_volume' => TransactionHelper::changeComaToDotAtRawVolume($rawVolume),
            'type' => $this->decideTransactionTypeByRawVolume($rawVolume),
            'import_id' => $import->id,
            'description' => $description,
            'accounting_date' => Carbon::parse($accountingDate),
            'transaction_date' => Carbon::parse($transactionDate),
            'decimal_volume' => TransactionHelper::rawVolumeToDecimal($rawVolume),
            'calculation_volume' => TransactionHelper::rawVolumeToDecimal($rawVolume),
            'sender_account_number' => $senderAccountNumber,
            'receiver_account_number' => $receiverAccountNumber,
        ];

        if (!$this->similarTransactionExists($user, $attributes)) {
            return Transaction::create($attributes);
        }

        $import->update(['transactions_skipped_count' => $import->transactions_skipped_count + 1]);

        return null;
    }
}
