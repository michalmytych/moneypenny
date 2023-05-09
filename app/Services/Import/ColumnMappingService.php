<?php

namespace App\Services\Import;

use Illuminate\Support\Collection;
use App\Models\Import\ColumnsMapping;

class ColumnMappingService
{
    public function all(): Collection
    {
        return ColumnsMapping::latest()->get();
    }
}
