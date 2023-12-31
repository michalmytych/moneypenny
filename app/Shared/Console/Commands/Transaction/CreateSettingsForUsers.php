<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Moneypenny\User\Models\Settings;
use App\Moneypenny\User\Models\User;
use Illuminate\Console\Command;

class CreateSettingsForUsers extends Command
{
    protected $signature = 'moneypenny:create-users-settings';

    protected $description = 'Create accounts settings for existing users.';

    public function handle(): int
    {
        $this->info("Creating settings for existing users...");

        foreach (User::cursor() as $user) {
            /** @var User $user */
            Settings::firstOrCreate([
                'user_id' => $user->id
            ], [
                'base_currency_code' => config('moneypenny.base_calculation_currency')
            ]);
        }

        $this->info('Success.');

        return 0;
    }
}
