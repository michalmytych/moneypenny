<?php

namespace App\Http\Requests\Web\Transaction;

use App\Models\Transaction\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'decimal_volume' => 'decimal:2|required',
            'sender' => 'nullable|max:255',
            'receiver' => 'nullable|max:255',
            'description' => 'required|string|min:5|max:255',
            'transaction_date' => 'required|date',
            'type' => [
                Rule::in([Transaction::TYPE_EXPENDITURE, Transaction::TYPE_INCOME])
            ],
            'currency' => [
                'required',
                Rule::in(config('moneypenny.supported_currencies'))
            ],
        ];
    }
}
