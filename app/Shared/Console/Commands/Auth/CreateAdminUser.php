<?php

namespace App\Shared\Console\Commands\Auth;

use App\Moneypenny\User\Models\User;
use Illuminate\Console\Command;
use Throwable;

class CreateAdminUser extends Command
{
    protected $signature = 'moneypenny:create-admin-user {name} {email} {password}';

    protected $description = 'Create new admin user account.';

    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->is_admin = true;

            $user->save();

        } catch (Throwable $throwable) {
            $this->error('Admin user was not created. Reason: [' . $throwable->getMessage() . ']');
        }
    }
}
