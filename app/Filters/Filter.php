<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Filter
{
    public const OPERATORS = [
        'eq',
        'lt',
        'gt',
        'lte',
        'gte',
        'ends',
        'starts',
        'contains',
    ];

    public const SQL_COMPARISON_OPERATORS = [
        'eq'  => '=',
        'lt'  => '<',
        'gt'  => '>',
        'lte' => '=<',
        'gte' => '>=',
    ];

    public function __construct(
        public ?string $column,
        public ?string $operatorAlias,
        public mixed   $value,
    ) {
    }

    public static function makeFromRequest(Request $request): Filter
    {
        return new self(
            column: $request->get('column'),
            operatorAlias: $request->get('operator'),
            value: $request->get('value'),
        );
    }

    public function applyOnQuery(Builder $builder): Builder
    {
        if (is_null($this->column) || is_null($this->operatorAlias)) {
            return $builder;
        }

        /** @var Filterable|Model $model */
        $model = $builder->getModel();

        $filterableColumns   = $model::getFilterableColumns()->toArray();
        $columnNotFilterable = !array_key_exists($this->column, $filterableColumns);
        $operatorNotAllowed  = !in_array($this->operatorAlias, self::OPERATORS);

        if ($columnNotFilterable || $operatorNotAllowed) {
            return $builder;
        }

        if (array_key_exists($this->operatorAlias, self::SQL_COMPARISON_OPERATORS)) {
            if (data_get($filterableColumns, $this->operatorAlias . '.' . 'input') === 'date') {
                return $builder->whereDate(
                    $this->column,
                    self::SQL_COMPARISON_OPERATORS[$this->operatorAlias],
                    Carbon::parse($this->value)
                );
            }

            return $builder->where(
                $this->column,
                self::SQL_COMPARISON_OPERATORS[$this->operatorAlias],
                $this->value
            );
        }

        if ($this->operatorAlias === 'contains') {
            return $builder->where($this->column, 'LIKE', "%$this->value%");
        }

        if ($this->operatorAlias === 'starts') {
            return $builder->where($this->column, 'LIKE', "$this->value%");
        }

        if ($this->operatorAlias === 'ends') {
            return $builder->where($this->column, 'LIKE', "%$this->value");
        }

        return $builder;
    }
}
