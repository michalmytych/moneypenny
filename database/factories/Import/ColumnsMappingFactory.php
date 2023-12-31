<?php

namespace Database\Factories\Import;

use App\Moneypenny\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColumnsMappingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'user_id' => User::factory()->firstOrCreate()->id,
            'transaction_date_column_index' => 0,
            'volume_column_index' => 1,
            'accounting_date_column_index' => 2,
            'sender_column_index' => 3,
            'receiver_column_index' => 4,
            'description_column_index' => 5,
            'currency_column_index' => 6,
            'sender_account_number_column_index' => 7,
            'receiver_account_number_column_index' => 8
        ];
    }
}
