<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\File;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            File::create([
                'name' => "file{$i}.csv",
                'path' => "files/file{$i}.csv",
                'size' => rand(1024, 2048),
            ]);
        }
    }
}
