<?php

namespace Tests\Feature\Traits;

use App\Models\Transaction\Transaction;
use App\Models\User;

trait CreatesTransactionForUser
{
    protected function createTransactionForUser(User $user, array $overrideAttributes = []): Transaction
    {
        $overrideAttributes['user_id'] = $user->id;
        return Transaction::factory()->create($overrideAttributes);
    }
}
