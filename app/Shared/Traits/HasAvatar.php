<?php

namespace App\Shared\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * @property-read mixed $id
 */
trait HasAvatar
{
    public function getAvatarPath(): string
    {
        // @todo - WTF? refactor
        $fileName = $this->id . '_avatar.jpeg';
        $fileExists = Storage::exists('public/avatars/' . $fileName);

        if ($fileExists) {
            return asset('storage/avatars/' . $fileName);
        }

        $fileName = $this->id . '_avatar.webp';
        $fileExists = Storage::exists('public/avatars/' . $fileName);

        if ($fileExists) {
            return asset('storage/avatars/' . $fileName);
        }

        return 'placeholders/avatar_placeholder.jpeg';
    }
}
