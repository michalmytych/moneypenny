<?php

namespace Tests\Feature\Traits;

use App\Models\Transaction\Transaction;
use App\Models\User;

trait CreatesTransactionForUser
{
    protected function createTransactionForUserWithoutEvents(User $user, array $overrideAttributes = []): Transaction
    {
        $transaction = null;

        Transaction::withoutEvents(function() use ($overrideAttributes, $user, &$transaction) {
            $overrideAttributes['user_id'] = $user->id;
            $transaction = Transaction::factory()->create($overrideAttributes);
        });

        return $transaction;
    }
}
