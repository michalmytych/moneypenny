<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\HasJsonFailedValidationResponse;

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
