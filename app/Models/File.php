<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $path
 * @property int $size
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'size'
    ];
}
