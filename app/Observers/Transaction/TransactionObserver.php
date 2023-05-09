<?php

namespace App\Observers\Transaction;

use App\Models\Transaction\Transaction;
use App\Jobs\Persona\CreateTransactionPersonaAssociation;
use App\Jobs\Transaction\UpdateUsersPersonalAccountSaldo;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        CreateTransactionPersonaAssociation::dispatch($transaction);
        UpdateUsersPersonalAccountSaldo::dispatch($transaction);
    }
}
