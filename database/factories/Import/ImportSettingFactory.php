<?php

namespace Database\Factories\Import;

use Exception;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportSettingFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'user_id' => User::factory()->firstOrCreate()->id,
            'start_row' => random_int(0, 5),
            'file_extension' => $this->faker->randomElement(['csv', 'xls', 'tsv', 'xlsx']),
            'delimiter' => $this->faker->randomElement([';', ',', '|']),
            'enclosure' => $this->faker->randomElement(['"', null]),
            'escape_character' => null,
            'input_encoding' => 'UTF-8'
        ];
    }
}
