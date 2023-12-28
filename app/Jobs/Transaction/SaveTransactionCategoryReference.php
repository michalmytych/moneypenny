<?php

namespace App\Jobs\Transaction;

use App\Models\Transaction\Transaction;
use App\Services\Transaction\Categorize\CategoryReferenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveTransactionCategoryReference implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public mixed $transactionId)
    {
    }

    public function handle(CategoryReferenceService $categoryReferenceService): void
    {
        $transaction = Transaction::findOrFail($this->transactionId);
        $categoryReferenceService->saveReference($transaction);
    }
}
