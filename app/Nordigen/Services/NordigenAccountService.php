<?php

namespace App\Nordigen\Services;

use App\Moneypenny\Synchronization\Models\Account;
use App\Moneypenny\User\Models\User;

class NordigenAccountService
{
    public function all(User $user)
    {
        return Account::whereUser($user)->latest()->get();
    }
}
