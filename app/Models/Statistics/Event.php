<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $type
 * @property null|string $payload
 * @property null|mixed $user_id
 * @property null|mixed $eventable_id
 * @property null|string $eventable_type
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'payload',
        'user_id',
        'eventable_id',
        'eventable_type',
    ];
}
