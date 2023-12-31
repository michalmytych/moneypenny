<?php

namespace App\File\Services;

use App\File\Models\File;
use App\File\Services\Traits\RegistersFileInDBAndStoresOnDisk;
use App\Moneypenny\Import\Services\ImportService;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Str;

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
        $fileModel->size = $file->getSize();
        $fileModel->path = "uploads/{$fileName}";
        $fileModel->import_setting_id = $importSettingId;
        $fileModel->name = $file->getClientOriginalName();

        $this->registerAndStoreFile($fileModel, $file, $fileName);

        $this->importService->importFromFile($fileModel->id, $importSettingId, $columnMappingId, $user);
    }
}
