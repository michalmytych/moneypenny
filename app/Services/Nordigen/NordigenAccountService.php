<?php

namespace App\Services\Nordigen;

use App\Models\User;
use App\Models\Synchronization\Account;

class NordigenAccountService
{
    public function all(User $user)
    {
        return Account::whereUser($user)->latest()->get();
    }
}
