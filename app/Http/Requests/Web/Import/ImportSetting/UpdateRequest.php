<?php

namespace App\Http\Requests\Web\Import\ImportSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'file_extension' => 'required|string',
            'delimiter' => 'required|string',
            'enclosure' => 'nullable|string',
            'start_row' => 'nullable|numeric',
            'escape_character' => 'nullable|string',
            'input_encoding' => 'nullable|string',
        ];
    }
}
