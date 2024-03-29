<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Import\ImportSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'path' => $this->faker->filePath(),
            'size' => $this->faker->randomNumber(4),
            'user_id' => User::factory()->firstOrCreate()->id,
            'import_setting_id' => ImportSetting::factory()->firstOrCreate()->id
        ];
    }
}
