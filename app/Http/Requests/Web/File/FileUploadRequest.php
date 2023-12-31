<?php

namespace App\Http\Requests\Web\File;

use App\File\Models\File;
use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'import_setting_id' => 'exists:import_settings,id|exclude_if:type,' . File::USER_AVATAR,
            'columns_mapping_id' => 'exists:columns_mappings,id|exclude_if:type,' . File::USER_AVATAR,
            'file' => 'required|max:6000',
            'type' => 'string'
        ];
    }
}
