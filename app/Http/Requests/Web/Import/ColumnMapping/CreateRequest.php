<?php

namespace App\Http\Requests\Web\Import\ColumnMapping;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'transaction_date_column_index' => 'nullable|numeric',
            'volume_column_index' => 'nullable|numeric',
            'accounting_date_column_index' => 'nullable|numeric',
            'sender_column_index' => 'nullable|numeric',
            'receiver_column_index' => 'nullable|numeric',
            'description_column_index' => 'nullable|numeric',
            'currency_column_index' => 'nullable|numeric',
            'sender_account_number_index' => 'nullable|numeric',
            'receiver_account_number_index' => 'nullable|numeric',
        ];
    }
}
