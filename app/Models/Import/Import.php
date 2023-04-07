<?php

namespace App\Models\Import;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $status
 * @property File $file
 */
class Import extends Model
{
    use HasFactory;

    public const STATUS_PROCESSING   = 0;
    public const STATUS_SAVED        = 1;
    public const STATUS_IMPORTING    = 2;
    public const STATUS_IMPORTED     = 3;
    public const STATUS_IMPORT_ERROR = 4;

    protected $fillable = [
        'status',
        'import_setting_id',
        'columns_mapping_id',
        'file_id',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
