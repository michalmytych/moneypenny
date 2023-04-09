<?php

namespace App\Services\Transaction;

use Carbon\Carbon;
use App\Models\Import\Import;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Import\ColumnsMapping;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;

class TransactionImportService
{
    public function importFileRowAsTransaction(Collection $row, Import $import, ColumnsMapping $columnsMapping): void
    {

        $sender          = data_get($row, $columnsMapping->sender_column_index);
        $rawVolume       = data_get($row, $columnsMapping->volume_column_index);
        $receiver        = data_get($row, $columnsMapping->receiver_column_index);
        $currency        = data_get($row, $columnsMapping->currency_column_index);
        $description     = data_get($row, $columnsMapping->description_column_index);
        $accountingDate  = data_get($row, $columnsMapping->accounting_date_column_index);
        $transactionDate = data_get($row, $columnsMapping->transaction_date_column_index);

        $attributes = [
            'sender'           => $sender,
            'receiver'         => $receiver,
            'currency'         => $currency,
            'raw_volume'       => $rawVolume,
            'import_id'        => $import->id,
            'description'      => $description,
            'accounting_date'  => Carbon::parse($accountingDate),
            'transaction_date' => Carbon::parse($transactionDate),
            'decimal_volume'   => TransactionHelper::rawVolumeToDecimal($rawVolume),
        ];

        if (!$this->similarTransactionExists($attributes)) {
            Transaction::create($attributes);
        }
    }

    private function similarTransactionExists(array $attributes): bool
    {
        $checkAttributes = [
            'transaction_date' => $attributes['transaction_date'],
            'accounting_date'  => $attributes['accounting_date'],
            'description'      => $attributes['description'],
            'raw_volume'       => $attributes['raw_volume'],
            'receiver'         => $attributes['receiver'],
            'currency'         => $attributes['currency'],
            'sender'           => $attributes['sender'],
        ];

        return (bool) Transaction::firstWhere($checkAttributes);
    }
}
