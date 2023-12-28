<?php

namespace App\Models\Auth;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $base_currency_code
 * @property mixed $user_id
 * @method   static whereUser($user)
 */
class Settings extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'base_currency_code'
    ];
}
