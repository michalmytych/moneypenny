<?php

namespace App\Http\Requests\Web\Transaction\Budget;

use App\Moneypenny\Budget\Models\Budget;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $decimal_volume
 */
class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|gt:0|required',
            'name' => 'required|string|min:3|max:255',
            'type' => [
                Rule::in([Budget::TYPE_DAY, Budget::TYPE_WEEK, Budget::TYPE_MONTH])
            ],
        ];
    }
}
