<?php

namespace App\Moneypenny\Import\Models;

use App\Moneypenny\User\Models\User;
use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $delimiter
 * @property string|null $enclosure
 * @property string|null $escape_character
 * @property string $input_encoding
 * @property int|null $start_row
 * @property int $id
 * @property mixed $user_id
 * @method static findOrFail(int $importSettingId)
 * @method static latest()
 * @method static create(array $validatedData)
 * @method static whereUser(User $user)
 */
class ImportSetting extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'name',
        'user_id',
        'start_row',
        'file_extension',
        'delimiter',
        'enclosure',
        'escape_character',
        'input_encoding'
    ];
}

