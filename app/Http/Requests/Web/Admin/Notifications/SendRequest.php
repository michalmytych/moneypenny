<?php

namespace App\Http\Requests\Web\Admin\Notifications;

use App\Models\Notification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'header' => 'required|min:3|max:64',
            'content' => 'required|min:5|max:255',
            'url' => 'required|max:512',
            'user_id' => 'nullable|exists:users,id',
            'type' => [
                'nullable',
                Rule::in([
                    Notification::TYPE_INFO,
                    Notification::TYPE_ERROR,
                    Notification::TYPE_EVENT,
                    Notification::TYPE_SUCCESS,
                    Notification::TYPE_WARNING
                ])
            ]
        ];
    }
}
