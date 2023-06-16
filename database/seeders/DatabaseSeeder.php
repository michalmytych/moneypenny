<?php

namespace Database\Seeders;

use Illuminate\Console\Concerns\InteractsWithIO;
use Throwable;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        } catch (Throwable $throwable) {
            echo 'Test user already exists.';
        }

        try {
            User::factory()->create([
                'name' => 'Guest User',
                'email' => 'guest@example.com',
            ]);
        } catch (Throwable $throwable) {
            echo 'Guest user already exists.';
        }


        $this->call([
            ImportSettingsTableSeeder::class,
            ColumnsMappingsTableSeeder::class,
            CategoriesTableSeeder::class,
//            TransactionsTableSeeder::class,
//            FilesTableSeeder::class,
        ]);
    }
}
