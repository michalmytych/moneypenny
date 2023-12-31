<?php

namespace App\Transaction\PersonalAccount;

use App\Moneypenny\PersonalAccount\Models\PersonalAccount;
use App\Moneypenny\User\Models\User;

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
