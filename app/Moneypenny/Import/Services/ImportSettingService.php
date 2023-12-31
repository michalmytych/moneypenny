<?php

namespace App\Moneypenny\Import\Services;

use App\Moneypenny\Import\Models\ImportSetting;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Collection;

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
