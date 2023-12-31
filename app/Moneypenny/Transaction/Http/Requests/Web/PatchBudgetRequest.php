<?php

namespace App\Moneypenny\Transaction\Http\Requests\Web;

use App\Moneypenny\Budget\Models\Budget;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $decimal_volume
 */
class PatchBudgetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'amount' => 'numeric|gte:0',
            'type' => [
                Rule::in([
                    Budget::TYPE_MONTH,
                    Budget::TYPE_WEEK,
                    Budget::TYPE_DAY
                ])
            ]
        ];
    }
}
