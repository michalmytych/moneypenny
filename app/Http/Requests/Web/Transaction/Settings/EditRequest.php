<?php

namespace App\Http\Requests\Web\Transaction\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'base_currency_code' => [
                Rule::in(config('moneypenny.supported_currencies'))
            ]
        ];
    }
}
