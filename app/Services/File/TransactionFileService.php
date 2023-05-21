<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\Import\ImportService;
use App\Services\File\Traits\RegistersFileInDBAndStoresOnDisk;

class TransactionFileService
{
    use RegistersFileInDBAndStoresOnDisk;

    public function __construct(private readonly ImportService $importService) {}

    public function uploadTransactions(mixed $requestFile, mixed $importSettingId, mixed $columnMappingId, User $user): void
    {
        $file = $requestFile;

        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $uuid = Str::uuid();

        $fileName = "upload_{$uuid}_{$timestamp}.{$extension}";

        $fileModel = new File();
        $fileModel->user_id = $user->id;
        $fileModel->name = $file->getClientOriginalName();
        $fileModel->path = "uploads/{$fileName}";
        $fileModel->size = $file->getSize();
        $fileModel->import_setting_id = $importSettingId;

        $this->registerAndStoreFile($fileModel, $file, $fileName);

        $this->importService->importFromFile($fileModel->id, $importSettingId, $columnMappingId, $user);
    }
}
