<?php

namespace App\Models\Import;

use App\Models\Traits\BelongsToUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int|null $transaction_date_column_index
 * @property int|null $accounting_date_column_index
 * @property int|null $sender_column_index
 * @property int|null $receiver_column_index
 * @property int|null $description_column_index
 * @property int|null $currency_column_index
 * @property int|null $volume_column_index
 * @property int|null $sender_account_number_column_index
 * @property int|null $receiver_account_number_column_index
 * @method static findOrFail(int $columnsMappingId)
 * @method static latest()
 * @method static create(array $data)
 * @method static whereUser(User $user)
 */
class ColumnsMapping extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'name',
        'user_id',
        'transaction_date_column_index',
        'volume_column_index',
        'accounting_date_column_index',
        'sender_column_index',
        'receiver_column_index',
        'description_column_index',
        'currency_column_index',
        'sender_account_number_column_index',
        'receiver_account_number_column_index'
    ];
}
