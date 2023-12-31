<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Transaction\PersonalAccount\SaldoService;
use Illuminate\Console\Command;

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
