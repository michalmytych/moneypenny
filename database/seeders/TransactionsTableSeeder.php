<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use App\Services\Helper\TransactionHelper;
use Illuminate\Foundation\Testing\WithFaker;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $rawVolume = fake()->randomElement(['-', ''])
                . fake()->numberBetween(0, 100)
                . ','
                . fake()->randomElement([
                    '00',
                    (string) fake()->randomNumber(2),
                ]);

            $type = Transaction::TYPE_INCOME;

            if (str_contains($rawVolume, '-')) {
                $type = Transaction::TYPE_EXPENDITURE;
            }

            Transaction::create([
                'transaction_date' => fake()->dateTimeBetween(),
                'accounting_date'  => fake()->dateTimeBetween(),
                'sender'           => fake()->name() . ' ' . fake()->lastName(),
                'receiver'         => fake()->name() . ' ' . fake()->lastName(),
                'raw_volume'       => $rawVolume,
                'type'             => $type,
                'decimal_volume'   => TransactionHelper::rawVolumeToDecimal($rawVolume),
                'description'      => fake()->realTextBetween(2, 20),
                'currency'         => fake()->randomElement(['USD', 'PLN', 'EUR']),
            ]);
        }
    }
}
