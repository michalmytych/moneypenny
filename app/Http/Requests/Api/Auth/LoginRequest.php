<?php

namespace App\Http\Requests\Api\Auth;

use App\Shared\Http\Traits\HasJsonFailedValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use HasJsonFailedValidationResponse;

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }
}
