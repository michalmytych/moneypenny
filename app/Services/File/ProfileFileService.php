<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileFileService
{
    public function uploadAvatar(UploadedFile $file, mixed $userId): void
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = $userId . '_avatar.' . $extension;

        $file->storePubliclyAs('public/avatars/', $fileName);
    }

    public function selectLibraryAvatar(?string $serverPath, mixed $userId): ?array
    {
        if (!$serverPath) {
            return null;
        }

        $targetPath = storage_path('app/public/avatars/' . $userId . '_avatar.jpeg');
        $srcPath = public_path($serverPath);

        if (File::exists($targetPath)) {
            File::delete($targetPath);
        }

        $copied = File::copy($srcPath, $targetPath);

        return [
            'copied' => $copied
        ];
    }
}
