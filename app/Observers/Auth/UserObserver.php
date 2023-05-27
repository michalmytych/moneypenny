<?php

namespace App\Observers\Auth;

use App\Models\User;
use App\Jobs\Auth\CreateUserSettings;

class UserObserver
{
    public function created(User $user): void
    {
        CreateUserSettings::dispatch($user);
    }
}
