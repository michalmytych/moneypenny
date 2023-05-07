<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $content
 * @property int $id
 */
class Notification extends Model
{
    public const TYPE_INFO = 0;

    public const TYPE_WARNING = 1;

    public const TYPE_ERROR = 2;

    public const TYPE_SUCCESS = 3;

    public const STATUS_UNREAD = 0;

    public const STATUS_READ = 1;

    use HasFactory;

    protected $fillable = [
        'status',
        'content',
        'type'
    ];
}
