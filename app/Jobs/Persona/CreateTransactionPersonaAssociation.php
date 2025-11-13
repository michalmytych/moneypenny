<?php

namespace App\Jobs\Persona;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Transaction\TransactionPersonaService;

class CreateTransactionPersonaAssociation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public mixed $transactionId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(TransactionPersonaService $transactionPersonaService): void
    {
        $transaction = Transaction::findOrFail($this->transactionId);
        $transactionPersonaService->createPersonasAssociations($transaction);
    }
}
