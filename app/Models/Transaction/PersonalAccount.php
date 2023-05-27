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

    protected $fillable = [
        'user_id',
        'value',
        'name'
    ];
}
