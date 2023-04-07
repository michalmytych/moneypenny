<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Import\ImportSetting;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class TransactionsImport implements ToCollection, WithCustomCsvSettings
{
    public function __construct(private ImportSetting $importSetting) { }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
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
}
