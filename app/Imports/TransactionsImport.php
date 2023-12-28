<?php

namespace App\Imports;

use App\Models\User;
use Throwable;
use App\Models\Import\Import;
use Illuminate\Support\Collection;
use App\Models\Import\ImportSetting;
use App\Models\Import\ColumnsMapping;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use App\Services\Transaction\TransactionImportService;

class TransactionsImport implements ToCollection, WithCustomCsvSettings, WithStartRow
{
    public function __construct(
        private readonly ImportSetting  $importSetting,
        private readonly ColumnsMapping $columnsMapping,
        private readonly Import         $import,
        private readonly User           $user
    ) {
    }

    /**
     * @param  Collection $collection
     * @throws Throwable
     */
    public function collection(Collection $collection): void
    {
        $this->import->update(['status' => Import::STATUS_IMPORTING]);

        try {
            foreach ($collection as $row) {
                /**
 * @var TransactionImportService $service 
*/
                $service = app(TransactionImportService::class);

                $service->importFileRowAsTransaction($row, $this->import, $this->columnsMapping, $this->user);
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
            'delimiter' => $this->importSetting->delimiter,
            'enclosure' => $this->importSetting->enclosure,
            'input_encoding' => $this->importSetting->input_encoding,
            'escape_character' => $this->importSetting->escape_character,
        ];

        return collect($settings)->filter()->toArray();
    }

    public function startRow(): int
    {
        return $this->importSetting->start_row ?? 0;
    }
}
