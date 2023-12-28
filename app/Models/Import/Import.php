<?php

namespace App\Models\Import;

use App\Models\File;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Transaction;
use App\Models\Synchronization\Synchronization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $status
 * @property File $file
 * @property int $id
 * @property int|null $file_id
 * @property int|null $synchronization_id
 * @property int $transactions_skipped_count
 * @method   static create(array $data)
 * @method   static whereUser(\App\Models\User $user)
 */
class Import extends Model
{
    use HasFactory, BelongsToUser;

    public const STATUS_PROCESSING = 0;
    public const STATUS_SAVED = 1;
    public const STATUS_IMPORTING = 2;
    public const STATUS_IMPORTED = 3;
    public const STATUS_IMPORT_ERROR = 4;

    protected $fillable = [
        'status',
        'user_id',
        'import_setting_id',
        'columns_mapping_id',
        'transactions_skipped_count',
        'synchronization_id',
        'file_id',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function synchronization(): BelongsTo
    {
        return $this->belongsTo(Synchronization::class);
    }

    public function addedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
