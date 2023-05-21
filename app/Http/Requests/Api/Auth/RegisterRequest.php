<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\HasJsonFailedValidationResponse;

class RegisterRequest extends FormRequest
{
    use HasJsonFailedValidationResponse;

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ];
    }
}
