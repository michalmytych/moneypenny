<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $delimiter
 * @property string|null $enclosure
 * @property string|null $escape_character
 * @property string $input_encoding
 */
class ImportSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_extension',
        'delimiter',
        'enclosure',
        'escape_character',
        'input_encoding'
    ];
}

