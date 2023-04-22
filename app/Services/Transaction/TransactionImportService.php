<?php

namespace App\Services\Transaction;

use Carbon\Carbon;
use App\Models\Import\Import;
use Illuminate\Support\Collection;
use App\Models\Import\ColumnsMapping;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;

class TransactionImportService
{
    public function importFileRowAsTransaction(Collection $row, Import $import, ColumnsMapping $columnsMapping): ?Transaction
    {
        $sender = data_get($row, $columnsMapping->sender_column_index);
        $rawVolume = data_get($row, $columnsMapping->volume_column_index);
        $receiver = data_get($row, $columnsMapping->receiver_column_index);
        $currency = data_get($row, $columnsMapping->currency_column_index);
        $description = data_get($row, $columnsMapping->description_column_index);
        $accountingDate = data_get($row, $columnsMapping->accounting_date_column_index);
        $transactionDate = data_get($row, $columnsMapping->transaction_date_column_index);

        $attributes = [
            'sender' => $sender,
            'receiver' => $receiver,
            'currency' => $currency,
            'raw_volume' => TransactionHelper::changeComaToDotAtRawVolume($rawVolume),
            'import_id' => $import->id,
            'description' => $description,
            'accounting_date' => Carbon::parse($accountingDate),
            'transaction_date' => Carbon::parse($transactionDate),
            'decimal_volume' => TransactionHelper::rawVolumeToDecimal($rawVolume),
            'calculation_volume' => TransactionHelper::rawVolumeToDecimal($rawVolume)
        ];

        if (!$this->similarTransactionExists($attributes)) {
            return Transaction::create($attributes);
        }

        $import->update(['transactions_skipped_count' => $import->transactions_skipped_count + 1]);

        return null;
    }

    public function similarTransactionExists(array $attributes): bool
    {
        return Transaction::query()
            ->whereDate('transaction_date', $attributes['transaction_date'])
            ->where('description', 'LIKE', '%' . $attributes['description'] . '%')
            ->where('decimal_volume', $attributes['decimal_volume'])
            ->exists();
    }
}
