<?php

namespace App\Services\Transaction\Settings;

use App\Models\User;
use App\Models\Auth\Settings;

class UserSettingsService
{
    public function assureUserSettings(User $user): Settings
    {
        return Settings::firstOrCreate(
            [
            'user_id' => $user->id,
            'base_currency_code' => config('moneypenny.base_calculation_currency')
            ]
        );
    }
}
