<?php

namespace App\Observers\Transaction;

use App\Models\Transaction\Transaction;
use App\Jobs\Persona\CreateTransactionPersonaAssociation;
use App\Jobs\Transaction\UpdateUsersPersonalAccountSaldo;
use App\Jobs\Transaction\ResolveTransactionCalculationVolume;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        //@todo - batch jobs
        CreateTransactionPersonaAssociation::dispatch($transaction->id);
        ResolveTransactionCalculationVolume::dispatch($transaction->id);
        // @todo - this will
        UpdateUsersPersonalAccountSaldo::dispatchSync($transaction->id);
    }
}
