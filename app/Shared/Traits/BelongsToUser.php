<?php

namespace App\Shared\Traits;

use App\Moneypenny\User\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method belongsTo(string $class)
 */
trait BelongsToUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
    }
}
