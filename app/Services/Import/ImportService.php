<?php

namespace App\Services\Import;

use App\Models\File;
use App\Models\Import\Import;
use Illuminate\Support\Facades\DB;
use App\Imports\TransactionsImport;
use App\Models\Import\ImportSetting;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Import\ColumnsMapping;
use App\Contracts\Services\Import\ImportServiceContract;

class ImportService implements ImportServiceContract
{
    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId)
    {
        $importSetting  = ImportSetting::findOrFail($importSettingId);
        $columnsMapping = ColumnsMapping::findOrFail($columnsMappingId);
        $file           = File::findOrFail($fileId);

        $import = new Import([
            'status'             => Import::STATUS_PROCESSING,
            'columns_mapping_id' => $columnsMappingId,
            'import_setting_id'  => $importSettingId,
            'file_id'            => $file->id,
        ]);

        $import->save();

        DB::transaction(function () use ($file, $importSetting, $columnsMapping, $import) {
            Excel::import(new TransactionsImport($importSetting, $columnsMapping, $import), $file->path);
        });

        $import->update(['status' => Import::STATUS_SAVED]);
    }

    public function create(array $data): Import
    {
        return Import::create($data);
    }
}