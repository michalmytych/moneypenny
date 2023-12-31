<?php

namespace App\Moneypenny\Import\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CreateImportSettingRequest extends FormRequest
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
