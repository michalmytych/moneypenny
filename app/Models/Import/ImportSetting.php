<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $delimiter
 * @property string|null $enclosure
 * @property string|null $escape_character
 * @property string $input_encoding
 * @property int|null $start_row
 * @property int $id
 */
class ImportSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_row',
        'file_extension',
        'delimiter',
        'enclosure',
        'escape_character',
        'input_encoding'
    ];
}

