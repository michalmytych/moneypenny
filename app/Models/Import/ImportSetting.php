<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

