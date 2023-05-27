<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $base_currency_code
 * @property mixed $user_id
 */
class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'base_currency_code'
    ];
}
