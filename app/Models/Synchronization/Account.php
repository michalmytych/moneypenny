<?php

namespace App\Models\Synchronization;

use App\Models\Traits\BelongsToUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static firstOrCreate(array $attributes, array $data)
 * @method static latest()
 * @method static whereUser(User $user)
 * @property int $id
 * @property string $nordigen_account_id
 */
class Account extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'nordigen_account_id',
        'synchronization_id'
    ];
}
