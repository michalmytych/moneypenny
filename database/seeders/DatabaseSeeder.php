<?php

namespace Database\Seeders;

use Throwable;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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
            echo 'Test user was not created. Reason: [' . $throwable->getMessage() . ']';
        }


        $this->call([
            ImportSettingsTableSeeder::class,
            ColumnsMappingsTableSeeder::class,
//            TransactionsTableSeeder::class,
//            FilesTableSeeder::class,
        ]);
    }
}
