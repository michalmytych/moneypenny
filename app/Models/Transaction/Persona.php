<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static orderBy(string $string)
 * @property string $associated_names
 * @property int $id
 * @property string $common_name
 * @property string $account_number
 */
class Persona extends Model
{
    use HasFactory;

    public const ACCOUNT_NUMBER_UNKNOWN = 'ACCOUNT_NUMBER_UNKNOWN';

    public const NAME_UNKNOWN = 'NAME_UNKNOWN';

    public const NO_COMMON_NAMES = 'NO_COMMON_NAMES';

    protected $fillable = [
        'common_name',
        'account_number',
        'associated_names'
    ];

    public function transactionsAsSender(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_persona_id', 'id');
    }

    public function transactionsAsReceiver(): HasMany
    {
        return $this->hasMany(Transaction::class, 'receiver_persona_id', 'id');
    }
}
