<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static firstWhere(string $string, mixed $id)
 */
class PersonalAccount extends Model
{
    use HasFactory;

    public const USER_SALDO_CACHE_KEY_PREFIX = 'account_saldo_';

    protected $fillable = [
        'user_id',
        'value',
        'name'
    ];
}
