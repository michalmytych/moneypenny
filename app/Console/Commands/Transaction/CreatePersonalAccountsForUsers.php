<?php

namespace App\Console\Commands\Transaction;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Transaction\PersonalAccount;
use App\Services\Transaction\PersonalAccount\SaldoService;

class CreatePersonalAccountsForUsers extends Command
{
    protected $signature = 'moneypenny:create-users-personal-accounts';

    protected $description = 'Create personal accounts records for existing users.';

    public function handle(SaldoService $saldoService): int
    {
        $this->info("Calculating user's default account saldo...");

        foreach (User::cursor() as $user) {
            // @todo - move to service
            /** @var User $user */
            $account = PersonalAccount::firstOrCreate([
                'user_id' => $user->id
            ], [
                'value' => $saldoService->calculate($user),
                'user_id' => $user->id,
                'name' => 'Default',
            ]);

            $this->line("Account saldo: $account->value PLN");
        }

        return 0;
    }
}
