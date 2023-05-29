<?php

namespace App\Services\Transaction\PersonalAccount;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\PersonalAccount;

class SaldoService
{
    public function getByUser(User $user)
    {
        $personalAccount = PersonalAccount::firstWhere('user_id', $user->id);
        return $personalAccount?->value ?? 0.0;
    }

    public function calculate(User $user): int
    {
        $saldo = 0;
        foreach (Transaction::whereUser($user)->cursor() as $transaction) {
            /** @var Transaction $transaction */
            if ($transaction->type === Transaction::TYPE_EXPENDITURE) {
                $saldo -= $transaction->{Transaction::CALCULATION_COLUMN};
            }

            if ($transaction->type === Transaction::TYPE_INCOME) {
                $saldo += $transaction->{Transaction::CALCULATION_COLUMN};
            }
        }

        return $saldo;
    }

    public function updateSaldo(Transaction $transaction): void
    {
        $personalAccount = PersonalAccount::firstWhere('user_id', $transaction->user->id);

        if ($transaction->type === Transaction::TYPE_EXPENDITURE) {
            $personalAccount->value -= $transaction->{Transaction::CALCULATION_COLUMN};
        }

        if ($transaction->type === Transaction::TYPE_INCOME) {
            $personalAccount->value += $transaction->{Transaction::CALCULATION_COLUMN};
        }

        $personalAccount->save();
    }
}
