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
        // @todo - refactor
        try {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        } catch (Throwable) {
            echo PHP_EOL . 'Test user already exists.' . PHP_EOL;
        }

        try {
            User::factory()->create([
                'name' => 'Guest User',
                'email' => 'guest@example.com',
            ]);
        } catch (Throwable) {
            echo PHP_EOL . 'Guest user already exists.' . PHP_EOL;
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
