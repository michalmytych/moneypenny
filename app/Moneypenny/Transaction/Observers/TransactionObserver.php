<?php

namespace App\Moneypenny\Transaction\Observers;

use App\Moneypenny\Persona\Jobs\CreateTransactionPersonaAssociation;
use App\Moneypenny\Transaction\Jobs\ResolveTransactionCalculationVolume;
use App\Moneypenny\Transaction\Jobs\SaveTransactionCategoryReference;
use App\Moneypenny\Transaction\Jobs\UpdateUsersPersonalAccountSaldo;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;

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
