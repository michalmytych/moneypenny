<?php

namespace App\Observers\Transaction;

use App\Models\Transaction\Transaction;
use App\Jobs\Persona\CreateTransactionPersonaAssociation;
use App\Jobs\Transaction\UpdateUsersPersonalAccountSaldo;
use App\Jobs\Transaction\SaveTransactionCategoryReference;
use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Jobs\Transaction\ResolveTransactionCalculationVolume;

readonly class TransactionObserver
{
    public function __construct(private CacheAdapterInterface $cacheAdapter)
    {
    }

    public function created(Transaction $transaction): void
    {
        $this->cacheAdapter->clearUserCache($transaction->user);

        CreateTransactionPersonaAssociation::dispatch($transaction->id);
        ResolveTransactionCalculationVolume::dispatch($transaction->id);
        UpdateUsersPersonalAccountSaldo::dispatch($transaction->id);
    }

    public function updating(Transaction $transaction): void
    {
        $this->cacheAdapter->clearUserCache($transaction->user);

        if($transaction->isDirty('category_id')){
            SaveTransactionCategoryReference::dispatch($transaction->id);
        }
    }
}
