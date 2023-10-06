<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $value
 */
class PersonalAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'value',
        'name'
    ];
}
