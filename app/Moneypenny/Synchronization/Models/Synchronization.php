<?php

namespace App\Moneypenny\Synchronization\Models;

use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\User\Models\User;
use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @var Carbon $created_at
 * @method static create(array $data)
 * @method static whereUser(User $user)
 * @property mixed $id
 * @property int $code
 * @property int $status
 * @property User $user
 */
class Synchronization extends Model
{
    use HasFactory, BelongsToUser;

    public const SYNC_STATUS_RUNNING = 0;
    public const SYNC_STATUS_FAILED = 1;
    public const SYNC_STATUS_SUCCEEDED = 2;

    protected $fillable = [
        'code',
        'status',
        'user_id'
    ];

    public function import(): HasOne
    {
        return $this->hasOne(Import::class);
    }
}
