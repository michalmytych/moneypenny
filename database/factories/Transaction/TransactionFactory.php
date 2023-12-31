<?php

namespace Database\Factories\Transaction;

use App\Moneypenny\Category\Models\Category;
use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $calcVolume = round(
            $this->faker->numberBetween(0.01, 1_000_000),
            2
        );

        $type = $this->faker->randomElement([
            Transaction::TYPE_INCOME,
            Transaction::TYPE_EXPENDITURE
        ]);

        return [
            'is_excluded_from_calculation' => $this->faker->boolean(),
            'receiver_account_number' => $this->faker->creditCardNumber(),
            'sender_account_number' => $this->faker->creditCardNumber(),
            'receiver_persona_id' => null,
            'calculation_volume' => $calcVolume,
            'sender_persona_id' => null,
            'transaction_date' => $this->faker->dateTimeBetween(now()->subDays(90), now()),
            'accounting_date' => $this->faker->dateTimeBetween(now()->subDays(90), now()),
            'decimal_volume' => $calcVolume,
            'description' => $this->faker->realText(40),
            'category_id' => Category::factory()->firstOrCreate()->id,
            'raw_volume' => $type === Transaction::TYPE_INCOME ? "$calcVolume" : "-$calcVolume",
            'import_id' => Import::factory()->firstOrCreate()->id,
            'receiver' => $this->faker->firstName() . ' ' . $this->faker->lastName() . ' ' . $this->faker->company(),
            'currency' => $this->faker->randomElement(config('moneypenny.supported_currencies')),
            'user_id' => User::inRandomOrder()->first()->id,
            'sender' => $this->faker->firstName() . ' ' . $this->faker->lastName() . ' ' . $this->faker->company(),
            'type' => $type
        ];
    }
}
