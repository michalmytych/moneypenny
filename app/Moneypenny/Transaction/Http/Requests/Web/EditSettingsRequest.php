<?php

namespace App\Moneypenny\Transaction\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditSettingsRequest extends FormRequest
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
