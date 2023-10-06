<?php

namespace App\Observers\Auth;

use App\Models\User;
use App\Jobs\Auth\CreateUserSettings;
use App\Services\Transaction\PersonalAccount\PersonalAccountService;

readonly class UserObserver
{
    public function __construct(private PersonalAccountService $personalAccountService)
    {
    }

    public function created(User $user): void
    {
        CreateUserSettings::dispatch($user);
        $this->personalAccountService->createForUser($user);
    }
}
