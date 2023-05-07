<?php

namespace App\Jobs\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Transaction\PersonalAccount\SaldoService;

class UpdateUsersPersonalAccountSaldo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Transaction $transaction) {}
    public function handle(SaldoService $saldoService): void
    {
        $saldoService->updateSaldo($this->transaction);
    }
}
