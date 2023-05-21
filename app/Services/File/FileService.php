<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Collection;

class FileService
{
    public function all(User $user): Collection
    {
        return File::whereUser($user)->latest()->get();
    }

    public function findOrFail(mixed $id, User $user): ?File
    {
        return File::whereUser($user)->findOrFail($id);
    }
}
