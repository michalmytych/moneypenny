<?php

namespace App\Transaction\Settings;

use App\Moneypenny\User\Models\Settings;
use App\Moneypenny\User\Models\User;

class UserSettingsService
{
    public function assureUserSettings(User $user): Settings
    {
        return Settings::firstOrCreate([
            'user_id' => $user->id,
            'base_currency_code' => config('moneypenny.base_calculation_currency')
        ]);
    }
}
