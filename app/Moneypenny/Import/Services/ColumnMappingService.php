<?php

namespace App\Moneypenny\Import\Services;

use App\Moneypenny\Import\Models\ColumnsMapping;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Collection;

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
