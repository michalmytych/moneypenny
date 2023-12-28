<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Import\ImportSetting;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            File::create(
                [
                'user_id' => User::inRandomOrder()->first()->id,
                'name' => "file{$i}.csv",
                'path' => "files/file{$i}.csv",
                'import_setting_id' => ImportSetting::inRandomOrder()->first()->id,
                'size' => rand(1024, 2048),
                ]
            );
        }
    }
}
