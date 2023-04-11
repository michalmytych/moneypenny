<?php

namespace App\Filters\Traits;

use App\Filters\Filter;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeApplyFilter(Builder $builder, Filter $filter): Builder
    {
        return $filter->applyOnQuery($builder);
    }

    abstract static function getFilterableColumns(): Collection;
}
