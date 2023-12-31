<?php

namespace App\Http\Requests\Api\Auth;

use App\Shared\Http\Traits\HasJsonFailedValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use HasJsonFailedValidationResponse;

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ];
    }
}
