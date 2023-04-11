<?php

namespace App\Models\Synchronization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static firstOrCreate(array $attributes, array $data)
 * @method static latest()
 * @property int $id
 * @property string $nordigen_account_id
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'nordigen_account_id',
        'synchronization_id'
    ];
}
