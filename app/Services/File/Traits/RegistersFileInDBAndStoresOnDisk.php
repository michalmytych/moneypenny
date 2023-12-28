<?php

namespace App\Services\File\Traits;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

trait RegistersFileInDBAndStoresOnDisk
{
    protected function registerAndStoreFile(File $fileModel, UploadedFile $fileObj, string $fileName): void
    {
        DB::transaction(
            function () use ($fileModel, $fileObj, $fileName) {
                $fileModel->save();
                $fileObj->storeAs('uploads', $fileName);
            }
        );
    }
}
