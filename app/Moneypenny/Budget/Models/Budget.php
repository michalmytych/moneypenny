<?php

namespace App\Moneypenny\Budget\Models;

use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static createMany(array[] $defaultBudgetsData)
 */
class Budget extends Model
{
    use HasFactory, BelongsToUser;

    public const TYPE_MONTH = 0;
    public const TYPE_WEEK = 1;
    public const TYPE_DAY = 2;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'name'
    ];
}
