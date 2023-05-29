<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Import\ImportSetting;

class ImportSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $importSettings = [
            [
                'name' => 'Alior CSV',
                'file_extension' => 'csv',
                'delimiter' => ';',
                'enclosure' => null,
                'escape_character' => null,
                'start_row' => 3,
                'user_id' => User::first()->id,
                'input_encoding' => 'Windows-1250',
            ],
            // ...
        ];

        foreach ($importSettings as $setting) {
            // @todo ASAP - rm this hack
            foreach (User::cursor() as $user) {
                $setting['user_id'] = $user->id;
                ImportSetting::create($setting);
            }
        }
    }
}
