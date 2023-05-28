<?php

namespace App\Models\Transaction;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
