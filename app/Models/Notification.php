<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $content
 * @property int $id
 * @method static whereUser(User $user)
 * @method static create(array $array)
 */
class Notification extends Model
{
    use BelongsToUser;

    public const TYPE_INFO = 0;

    public const TYPE_WARNING = 1;

    public const TYPE_ERROR = 2;

    public const TYPE_SUCCESS = 3;

    public const TYPE_EVENT = 4;

    public const STATUS_UNREAD = 0;

    public const STATUS_READ = 1;

    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'content',
        'type'
    ];
}
