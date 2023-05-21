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
        $cacheKey = PersonalAccount::USER_SALDO_CACHE_KEY_PREFIX . $user->id;

        if (Cache::missing($cacheKey)) {
            $personalAccount = PersonalAccount::firstWhere('user_id', $user->id);
            $value = $personalAccount?->value ?? 0.0;
            Cache::put($cacheKey, (float) $value);
            return $value;
        }

        return Cache::get($cacheKey);
    }

    public function calculate(): int
    {
        $saldo = 0;
        foreach (Transaction::cursor() as $transaction) {
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
