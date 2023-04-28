<?php

namespace App\Models\Transaction;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static applyFilter(Filter $filter)
 * @method static create(array $data)
 * @method static firstWhere(array $attributes)
 * @method static findOrFail(int $id)
 * @method static cursor()
 * @method static count()
 * @property string $sender
 * @property string $receiver
 * @property int $id
 * @property Persona|null $senderPersona
 * @property Persona|null $receiverPersona
 * @property string $description
 * @property string|null $receiver_account_number
 * @property string|null $sender_account_number
 */
class Transaction extends Model
{
    use HasFactory, Filterable;

    const TYPE_UNKNOWN = 0;
    const TYPE_INCOME = 1;
    const TYPE_EXPENDITURE = 2;

    protected $fillable = [
        'receiver_account_number',
        'sender_account_number',
        'receiver_persona_id',
        'calculation_volume',
        'sender_persona_id',
        'transaction_date',
        'accounting_date',
        'decimal_volume',
        'description',
        'raw_volume',
        'import_id',
        'receiver',
        'currency',
        'sender'
    ];

    protected $casts = [
        'transaction_date' => 'datetime'
    ];

    public static function getFilterableColumns(): Collection
    {
        return collect([
            'transaction_date' => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input' => 'date',
            ],
            'accounting_date' => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input' => 'date',
            ],
            'decimal_volume' => [
                'operators' => ['lte', 'eq', 'gte', 'lt', 'gt'],
                'input' => 'number',
            ],
            'sender' => [
                'operators' => ['starts', 'ends', 'contains', 'eq'],
                'input' => 'text',
            ],
            'receiver' => [
                'operators' => ['starts', 'ends', 'contains', 'eq'],
                'input' => 'text',
            ],
            'description' => [
                'operators' => ['contains'],
                'input' => 'text',
            ],
            'currency' => [
                'operators' => ['eq'],
                'input' => 'text',
            ],
        ]);
    }

    public function senderPersona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'sender_persona_id');
    }

    public function receiverPersona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'receiver_persona_id');
    }
}
