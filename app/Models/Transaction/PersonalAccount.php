<?php

namespace App\Models\Transaction;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $value
 * @method   static whereUser(mixed $user)
 */
class PersonalAccount extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'value',
        'name'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
