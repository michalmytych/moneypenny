<?php

namespace App\Http\Requests\Web\Transaction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $decimal_volume
 */
class PatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id'
        ];
    }
}
