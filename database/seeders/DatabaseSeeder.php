<?php

namespace Database\Seeders;

use Throwable;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Console\Concerns\InteractsWithIO;

class DatabaseSeeder extends Seeder
{
    use InteractsWithIO;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        } catch (Throwable) {
            $this->command->warn('⚠️ Test user already exists.');
        }

        try {
            User::factory()->create([
                'name' => 'Guest User',
                'email' => 'guest@example.com',
            ]);
        } catch (Throwable) {
            $this->command->warn('⚠️ Guest user already exists.');
        }

        $this->call([
            ImportSettingsTableSeeder::class,
            ColumnsMappingsTableSeeder::class,
            CategoriesTableSeeder::class,
            // TransactionsTableSeeder::class,
            // FilesTableSeeder::class,
        ]);
    }
}
