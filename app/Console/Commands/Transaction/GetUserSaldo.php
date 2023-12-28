<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use App\Services\Transaction\PersonalAccount\SaldoService;

class GetUserSaldo extends Command
{
    protected $signature = 'moneypenny:saldo';

    protected $description = "Calculate user's current saldo.";

    public function handle(): int
    {
        $this->info("Calculating user's default account saldo...");

        $saldo = app(SaldoService::class)->calculate();

        $this->line("Saldo: $saldo PLN");

        return 0;
    }
}
