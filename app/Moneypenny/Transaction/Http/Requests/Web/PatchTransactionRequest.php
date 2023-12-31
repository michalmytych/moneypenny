<?php

namespace App\Moneypenny\Transaction\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $decimal_volume
 */
class PatchTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id'
        ];
    }
}
