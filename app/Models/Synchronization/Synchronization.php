<?php

namespace App\Models\Synchronization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
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
}
