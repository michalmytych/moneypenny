<?php

namespace App\Services\Transaction\PersonalAccount;

use App\Models\User;
use App\Models\Transaction\PersonalAccount;

readonly class PersonalAccountService
{
    public function __construct(private SaldoService $saldoService)
    {}

    public function createForUser(User $user): PersonalAccount
    {
        return PersonalAccount::firstOrCreate([
            'user_id' => $user->id
        ], [
            'value' => $this->saldoService->calculate($user),
            'user_id' => $user->id,
            'name' => 'Default',
        ]);
    }
}
