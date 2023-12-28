<?php

namespace Database\Factories\Import;

use App\Models\File;
use App\Models\Import\ColumnsMapping;
use App\Models\Import\Import;
use App\Models\Import\ImportSetting;
use App\Models\Synchronization\Synchronization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $randomStatus = $this->faker->randomElement([
            Import::STATUS_SAVED,
            Import::STATUS_IMPORTED,
            Import::STATUS_IMPORTING,
            Import::STATUS_PROCESSING,
            Import::STATUS_IMPORT_ERROR
        ]);

        return [
            'status' => $randomStatus,
            'user_id' => User::factory()->firstOrCreate()->id,
            'import_setting_id' => ImportSetting::factory()->firstOrCreate()->id,
            'columns_mapping_id' => ColumnsMapping::factory()->firstOrCreate()->id,
            'transactions_skipped_count' => random_int(0, 1000),
            'synchronization_id' => Synchronization::factory()->firstOrCreate()->id,
            'file_id' => File::factory()->firstOrCreate()->id,
        ];
    }
}
