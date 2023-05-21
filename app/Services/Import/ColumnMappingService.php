<?php

namespace App\Services\Import;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Import\ColumnsMapping;

class ColumnMappingService
{
    public function all(User $user): Collection
    {
        return ColumnsMapping::whereUser($user)->latest()->get();
    }

    public function create(User $user, array $data): ColumnsMapping
    {
        $data['user_id'] = $user->id;
        return ColumnsMapping::create($data);
    }
}
