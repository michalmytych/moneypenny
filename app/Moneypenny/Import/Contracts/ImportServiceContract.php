<?php

namespace App\Moneypenny\Import\Contracts;

use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\User\Models\User;

interface ImportServiceContract
{
    public function create(User $user, array $data): Import;

    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId, User $user);
}
