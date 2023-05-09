<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $path
 * @property int $size
 * @property int $import_setting_id
 * @property int $id
 * @method static findOrFail(int $fileId)
 * @method static latest()
 */
class File extends Model
{
    use HasFactory;

    public const USER_AVATAR = 'USER_AVATAR';

    protected $fillable = [
        'name',
        'path',
        'size',
        'import_setting_id'
    ];
}
