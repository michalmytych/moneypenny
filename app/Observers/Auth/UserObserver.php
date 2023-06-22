<?php

namespace App\Observers\Auth;

use App\Models\User;
use App\Jobs\Auth\CreateUserSettings;
use App\Models\Transaction\PersonalAccount;
use App\Services\Transaction\PersonalAccount\SaldoService;

class UserObserver
{
    public function created(User $user): void
    {
        // @todo - regular dispatch
        CreateUserSettings::dispatch($user);

        // @todo - move to service
        PersonalAccount::firstOrCreate([
            'user_id' => $user->id
        ], [
            'value' => app(SaldoService::class)->calculate($user),
            'user_id' => $user->id,
            'name' => 'Default',
        ]);
    }
}
