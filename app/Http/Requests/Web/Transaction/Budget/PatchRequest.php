<?php

namespace App\Http\Requests\Web\Transaction\Budget;

use Illuminate\Validation\Rule;
use App\Models\Transaction\Budget;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $decimal_volume
 */
class PatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'amount' => 'numeric|gte:0',
            'type' => [
                Rule::in(
                    [
                    Budget::TYPE_MONTH,
                    Budget::TYPE_WEEK,
                    Budget::TYPE_DAY
                    ]
                )
            ]
        ];
    }
}
