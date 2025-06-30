<?php

namespace Database\Factories\Transaction;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $category = Str::of($this->faker->word())->lower()->toString();
        return [
            'code' => $category,
            'name' => $category,
            'color_hex' => $this->faker->hexColor(),
        ];
    }
}
