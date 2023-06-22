<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use Illuminate\Foundation\Testing\WithFaker;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker;

    public function run(): void
    {
        Transaction::factory(200)->create();
    }
}
