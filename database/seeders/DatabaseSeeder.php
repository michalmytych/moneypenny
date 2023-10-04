<?php

namespace Database\Seeders;

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
        $this->call([
            UsersTableSeeder::class,
            ImportSettingsTableSeeder::class,
            ColumnsMappingsTableSeeder::class,
            CategoriesTableSeeder::class,
            // TransactionsTableSeeder::class,
            // FilesTableSeeder::class,
        ]);
    }
}
