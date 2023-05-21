<?php

namespace App\Services\Nordigen;

use App\Models\Synchronization\Account;
use App\Models\User;

class NordigenAccountService
{
    public function all(User $user)
    {
        return Account::whereUser($user)->latest()->get();
    }
}
