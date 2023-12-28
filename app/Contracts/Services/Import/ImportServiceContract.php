<?php

namespace App\Contracts\Services\Import;

use App\Models\User;
use App\Models\Import\Import;

interface ImportServiceContract
{
    public function create(User $user, array $data): Import;

    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId, User $user);
}
