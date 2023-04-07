<?php

namespace App\Contracts\Services\Import;

use App\Models\Import\Import;

interface ImportServiceContract
{
    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId);

    public function create(array $data): Import;
}
