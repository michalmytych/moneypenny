<?php

namespace App\Services\Import;

use App\Models\File;
use App\Models\Import\Import;
use Illuminate\Support\Facades\DB;
use App\Imports\TransactionsImport;
use App\Models\Import\ImportSetting;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{
    public function importFromFile(int $fileId, int $importSettingId)
    {
        $importSetting = ImportSetting::findOrFail($importSettingId);
        $file          = File::findOrFail($fileId);

        $import = new Import([
            'status'            => Import::STATUS_PROCESSING,
            'import_setting_id' => $importSettingId,
            'file_id'           => $file->id,
        ]);

        $import->save();

        DB::transaction(function () use ($file, $importSetting) {
            Excel::import(new TransactionsImport($importSetting), $file->path);
        });

        $import->update(['status' => Import::STATUS_COMPLETED]);
    }
}
