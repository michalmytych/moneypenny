<?php

namespace App\Filters\Traits;

use App\Filters\Filter;
use JetBrains\PhpStorm\Pure;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    #[Pure] public function scopeApplyFilter(Builder $builder, Filter $filter): Builder
    {
        return $filter->applyOnQuery($builder);
    }

    abstract static function getFilterableColumns(): Collection;
}
