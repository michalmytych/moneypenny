<?php

namespace Tests\Feature\Traits;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;

trait CreatesTransactionForUser
{
    protected function createTransactionForUserWithoutEvents(User $user, array $overrideAttributes = []): Transaction
    {
        $transaction = null;

        Transaction::withoutEvents(function() use ($overrideAttributes, $user, &$transaction) {
            $transaction = $this->createTransactionForUser($user, $overrideAttributes);
        });

        return $transaction;
    }

    protected function createTransactionForUser(User $user, array $overrideAttributes = []): Transaction
    {
        $overrideAttributes['user_id'] = $user->id;

        return Transaction::factory()->create($overrideAttributes);
    }
}
