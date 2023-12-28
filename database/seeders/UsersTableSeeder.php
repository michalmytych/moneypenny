<?php

namespace Database\Seeders;

use Throwable;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::factory()->create(
                [
                'name' => 'Test User',
                'email' => 'test@example.com',
                ]
            );
        } catch (Throwable) {
            $this->command->warn('  ⚠️ Test user already exists.');
        }

        try {
            User::factory()->create(
                [
                'name' => 'Guest User',
                'email' => 'guest@example.com',
                ]
            );
        } catch (Throwable) {
            $this->command->warn('  ⚠️ Guest user already exists.');
        }

        try {
            User::factory()
                ->admin()
                ->create(
                    [
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    ]
                );
        } catch (Throwable) {
            $this->command->warn('  ⚠️ Admin user already exists.');
        }
    }
}
