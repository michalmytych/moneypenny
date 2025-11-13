<?php

namespace App\Console\Commands\Transaction;

use App\Models\User;
use Illuminate\Console\Command;
use App\Services\Transaction\PersonalAccount\PersonalAccountService;

class CreatePersonalAccountsForUsers extends Command
{
    protected $signature = 'moneypenny:create-users-personal-accounts';

    protected $description = 'Create personal accounts records for existing users.';

    public function handle(PersonalAccountService $accountService): int
    {
        $this->info("Calculating user's default account saldo...");

        foreach (User::cursor() as $user) {
            $account = $accountService->createForUser($user);

            $this->line("Account saldo: $account->value PLN");
        }

        return 0;
    }
}
