<?php

namespace App\Shared\Filters\Traits;

use App\Shared\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait Filterable
{
    public function scopeApplyFilter(Builder $builder, Filter $filter): Builder
    {
        return $filter->applyOnQuery($builder);
    }

    abstract static function getFilterableColumns(): Collection;
}
