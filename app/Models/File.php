<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $name
 * @property string $path
 * @property int $size
 * @property int $import_setting_id
 * @property int $id
 * @property mixed $user_id
 * @method static findOrFail(int $fileId)
 * @method static latest()
 * @method static whereUser(User $user)
 */
class File extends Model
{
    use HasFactory, BelongsToUser;

    public const USER_AVATAR = 'USER_AVATAR';
    public const TRANSACTIONS_IMPORT = 'TRANSACTIONS_IMPORT';

    protected $fillable = [
        'name',
        'path',
        'size',
        'user_id',
        'import_setting_id'
    ];
}
