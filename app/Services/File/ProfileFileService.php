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

    public function selectLibraryAvatar(?string $serverPath, mixed $userId): mixed
    {
        if (!$serverPath) {
            return null;
        }

        $targetPath = public_path('avatars/' . $userId . '_avatar.jpeg');
        $srcPath = asset($serverPath);

        dd(File::copy($srcPath, $targetPath));
    }
}
