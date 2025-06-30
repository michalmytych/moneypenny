<?php

namespace App\Observers\Auth;

use App\Models\User;
use App\Services\Transaction\PersonalAccount\PersonalAccountService;

readonly class UserObserver
{
    public function __construct(private PersonalAccountService $personalAccountService)
    {
    }

    public function created(User $user): void
    {
        $this->personalAccountService->createForUser($user);
    }
}
