<?php

namespace App\Moneypenny\User\Observers;

use App\Moneypenny\User\Jobs\CreateUserSettings;
use App\Moneypenny\User\Models\User;
use App\Transaction\PersonalAccount\PersonalAccountService;

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
