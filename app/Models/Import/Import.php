<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $status
 */
class Import extends Model
{
    use HasFactory;

    public const STATUS_PROCESSING = 0;
    public const STATUS_COMPLETED  = 1;

    protected $fillable = [
        'status',
        'import_setting_id',
        'file_id',
    ];
}
