<?php

namespace App\Models\Transaction;

use App\Filters\Filter;
use Illuminate\Support\Collection;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static applyFilter(Filter $filter)
 */
class Transaction extends Model
{
    use HasFactory, Filterable;

    const TYPE_UNKNOWN     = 0;
    const TYPE_INCOME      = 1;
    const TYPE_EXPENDITURE = 2;

    protected $fillable = [
        'transaction_date',
        'accounting_date',
        'decimal_volume',
        'raw_volume',
        'sender',
        'receiver',
        'description',
        'currency',
    ];

    public static function getFilterableColumns(): Collection
    {
        return collect([
            'transaction_date' => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input'     => 'date',
            ],
            'accounting_date'  => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input'     => 'date',
            ],
            'decimal_volume'   => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input'     => 'number',
            ],
            'sender'           => [
                'operators' => ['starts', 'ends', 'contains', 'eq'],
                'input'     => 'text',
            ],
            'receiver'         => [
                'operators' => ['starts', 'ends', 'contains', 'eq'],
                'input'     => 'text',
            ],
            'description'      => [
                'operators' => ['contains'],
                'input'     => 'text',
            ],
            'currency'         => [
                'operators' => ['eq'],
                'input'     => 'text',
            ],
        ]);
    }
}
