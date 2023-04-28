<?php

namespace App\Observers\Transaction;

use App\Jobs\Persona\CreateTransactionPersonaAssociation;
use App\Models\Transaction\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        CreateTransactionPersonaAssociation::dispatch($transaction);
    }
}
