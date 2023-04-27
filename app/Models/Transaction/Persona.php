<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @property string $associated_names
 * @property int $id
 * @property string $common_name
 */
class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'common_name',
        'associated_names'
    ];
}
