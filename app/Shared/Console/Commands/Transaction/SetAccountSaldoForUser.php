<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Moneypenny\PersonalAccount\Models\PersonalAccount;
use App\Moneypenny\User\Models\User;
use Illuminate\Console\Command;

class SetAccountSaldoForUser extends Command
{
    protected $signature = 'moneypenny:set-saldo-by-email {email}';

    protected $description = "Set user's default account saldo by e-mail.";

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::firstWhere(['email' => $email]);

        if (!$user) {
            $this->error("User of e-mail $email not found!");
            return -1;
        }

        $this->info("Setting saldo on account [Default] for user [$user->id]");
        $value = $this->ask('Type in value (eg. 3500.00): ');
        $floatValue = floatval($value);

        $personalAccount = PersonalAccount::firstWhere([
            'user_id' => $user->id,
            'name' => 'Default'
        ]);

        $personalAccount = tap($personalAccount)->update([
            'value' => $floatValue
        ]);

        $this->info("Saldo value updated: " . $personalAccount->value . 'PLN');

        return 0;
    }
}
