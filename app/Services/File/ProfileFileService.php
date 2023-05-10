<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;

class ProfileFileService
{
    public function uploadAvatar(UploadedFile $file, mixed $userId): void
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = $userId . '_avatar.' . $extension;

        $file->storePubliclyAs('public/avatars/', $fileName);
    }
}
