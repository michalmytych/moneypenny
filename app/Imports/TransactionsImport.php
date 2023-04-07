<?php

namespace App\Imports;

use Throwable;
use Carbon\Carbon;
use App\Models\Import\Import;
use Illuminate\Support\Collection;
use App\Models\Import\ImportSetting;
use App\Models\Import\ColumnsMapping;
use App\Models\Transaction\Transaction;
use App\Services\Helper\TransactionHelper;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class TransactionsImport implements ToCollection, WithCustomCsvSettings, WithStartRow
{
    public function __construct(
        private ImportSetting  $importSetting,
        private ColumnsMapping $columnsMapping,
        private Import         $import
    ) {
    }

    /**
     * @param Collection $collection
     * @throws Throwable
     */
    public function collection(Collection $collection)
    {
        $this->import->update(['status' => Import::STATUS_IMPORTING]);

        try {
            foreach ($collection as $row) {
                $transactionDate = data_get($row, $this->columnsMapping->transaction_date_column_index);
                $accountingDate = data_get($row, $this->columnsMapping->accounting_date_column_index);
                $sender = data_get($row, $this->columnsMapping->sender_column_index);
                $receiver = data_get($row, $this->columnsMapping->receiver_column_index);
                $description = data_get($row, $this->columnsMapping->description_column_index);
                $currency = data_get($row, $this->columnsMapping->currency_column_index);
                $rawVolume = data_get($row, $this->columnsMapping->volume_column_index);

                Transaction::create([
                    'transaction_date' => Carbon::parse($transactionDate),
                    'accounting_date'  => Carbon::parse($accountingDate),
                    'sender'           => $sender,
                    'receiver'         => $receiver,
                    'description'      => $description,
                    'currency'         => $currency,
                    'decimal_volume'   => TransactionHelper::rawVolumeToDecimal($rawVolume),
                    'raw_volume'       => $rawVolume,
                ]);
            }

            $this->import->update(['status' => Import::STATUS_IMPORTED]);

        } catch (Throwable $throwable) {
            $this->import->update(['status' => Import::STATUS_IMPORT_ERROR]);

            throw $throwable;
        }
    }

    public function getCsvSettings(): array
    {
        $settings = [
            'delimiter'        => $this->importSetting->delimiter,
            'enclosure'        => $this->importSetting->enclosure,
            'escape_character' => $this->importSetting->escape_character,
            'input_encoding'   => $this->importSetting->input_encoding,
        ];

        return collect($settings)->filter()->toArray();
    }

    public function startRow(): int
    {
        return $this->importSetting->start_row ?? 0;
    }
}
