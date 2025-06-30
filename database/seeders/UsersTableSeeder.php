<?php

namespace Database\Seeders;

use Throwable;
use App\Models\User;
use App\Services\Transaction\Settings\UserSettingsService;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
            app(UserSettingsService::class)->assureUserSettings($user);
        } catch (UniqueConstraintViolationException) {
            $this->command->warn('  ⚠️ Test user already exists.');
        }

        try {
            $user = User::factory()->create([
                'name' => 'Guest User',
                'email' => 'guest@example.com',
            ]);
            app(UserSettingsService::class)->assureUserSettings($user);
        } catch (UniqueConstraintViolationException) {
            $this->command->warn('  ⚠️ Guest user already exists.');
        }

        try {
            $user = User::factory()
                ->admin()
                ->create([
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                ]);
            app(UserSettingsService::class)->assureUserSettings($user);
        } catch (UniqueConstraintViolationException) {
            $this->command->warn('  ⚠️ Admin user already exists.');
        }
    }
}
