<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Import\ImportSetting;

class ImportSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importSettings = [
            [
                'name' => 'CSV Import',
                'file_extension' => 'csv',
                'delimiter' => ',',
                'enclosure' => '"',
                'escape_character' => '\\',
                'input_encoding' => 'UTF-8',
            ],
            [
                'name' => 'Excel Import',
                'file_extension' => 'xlsx',
                'delimiter' => '',
                'enclosure' => '',
                'escape_character' => '',
                'input_encoding' => 'UTF-8',
            ],
            [
                'name' => 'XML Import',
                'file_extension' => 'xml',
                'delimiter' => '',
                'enclosure' => null,
                'escape_character' => null,
                'input_encoding' => 'UTF-8',
            ],
        ];

        foreach ($importSettings as $setting) {
            ImportSetting::create($setting);
        }
    }
}
