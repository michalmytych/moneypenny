<?php

namespace App\Services\Import;

use App\Models\Import\ImportSetting;
use Illuminate\Support\Collection;

class ImportSettingService
{
    public function all(): Collection
    {
        return ImportSetting::latest()->get();
    }
}
