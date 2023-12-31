<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Moneypenny\User\Models\User;
use App\Transaction\PersonalAccount\PersonalAccountService;
use Illuminate\Console\Command;

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
