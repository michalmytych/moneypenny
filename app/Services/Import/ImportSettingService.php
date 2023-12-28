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

    public function findOrFail(mixed $id): ImportSetting
    {
        return ImportSetting::findOrFail($id);
    }

    public function update(ImportSetting $importSetting, array $data): ImportSetting
    {
        return tap($importSetting)->update($data);
    }
}
