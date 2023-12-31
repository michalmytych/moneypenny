<?php

namespace App\Moneypenny\Persona\Jobs;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\Transaction\TransactionPersonaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
