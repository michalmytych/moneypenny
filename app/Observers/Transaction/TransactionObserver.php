<?php

namespace App\Observers\Transaction;

use App\Models\Transaction\Transaction;
use App\Jobs\Persona\CreateTransactionPersonaAssociation;
use App\Jobs\Transaction\UpdateUsersPersonalAccountSaldo;
use App\Jobs\Transaction\SaveTransactionCategoryReference;
use App\Jobs\Transaction\ResolveTransactionCalculationVolume;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        CreateTransactionPersonaAssociation::dispatch($transaction->id);
        ResolveTransactionCalculationVolume::dispatch($transaction->id);
        UpdateUsersPersonalAccountSaldo::dispatch($transaction->id);
    }

    public function updating(Transaction $transaction): void
    {
        if($transaction->isDirty('category_id')){
            SaveTransactionCategoryReference::dispatch($transaction->id);
        }
    }
}
