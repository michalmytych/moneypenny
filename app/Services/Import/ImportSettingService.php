<?php

namespace App\Services\Import;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Import\ImportSetting;

class ImportSettingService
{
    public function all(User $user): Collection
    {
        return ImportSetting::whereUser($user)->latest()->get();
    }
}
