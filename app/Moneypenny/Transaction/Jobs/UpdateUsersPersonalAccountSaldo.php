<?php

namespace App\Moneypenny\Transaction\Jobs;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\PersonalAccount\SaldoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUsersPersonalAccountSaldo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public mixed $transactionId) {}
    public function handle(SaldoService $saldoService): void
    {
        $transaction = Transaction::findOrFail($this->transactionId);
        $saldoService->updateSaldo($transaction);
    }
}
