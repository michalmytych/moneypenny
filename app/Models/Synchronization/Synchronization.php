<?php

namespace App\Models\Synchronization;

use App\Models\Import\Import;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @var Carbon $created_at
 * @method static create()
 */
class Synchronization extends Model
{
    use HasFactory;

    public const SYNC_STATUS_RUNNING = 0;
    public const SYNC_STATUS_FAILED = 1;
    public const SYNC_STATUS_SUCCEEDED = 2;

    protected $fillable = [
        'status',
    ];

    public function import(): HasOne
    {
        return $this->hasOne(Import::class);
    }
}
