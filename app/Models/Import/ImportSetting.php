<?php

namespace App\Models\Import;

use App\Models\User;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $delimiter
 * @property string|null $enclosure
 * @property string|null $escape_character
 * @property string $input_encoding
 * @property int|null $start_row
 * @property int $id
 * @property mixed $user_id
 * @method   static findOrFail(int $importSettingId)
 * @method   static latest()
 * @method   static create(array $validatedData)
 * @method   static whereUser(User $user)
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

