<?php

namespace App\Moneypenny\User\Models;

use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $base_currency_code
 * @property mixed $user_id
 * @method static whereUser($user)
 */
class Settings extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'base_currency_code'
    ];
}
