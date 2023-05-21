<?php

namespace App\Contracts\Services\Import;

use App\Models\Import\Import;
use App\Models\User;

interface ImportServiceContract
{
    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId, User $user);

    public function create(User $user, array $data): Import;
}
