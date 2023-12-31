<?php

namespace App\Moneypenny\PersonalAccount\Models;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $value
 * @property int $id
 * @method static whereUser(mixed $user)
 * @method static firstOrCreate(array $attributes, array $data)
 */
class PersonalAccount extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'external_reference',
        'account_id',
        'user_id',
        'value',
        'name'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
