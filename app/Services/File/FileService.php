<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Collection;

class FileService
{
    public function all(): Collection
    {
        return File::latest()->get();
    }

    public function findOrFail(mixed $id): ?File
    {
        return File::findOrFail($id);
    }
}
