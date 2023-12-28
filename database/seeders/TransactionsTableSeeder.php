<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker, WithoutModelEvents;

    public function run(): void
    {
        $this->withoutModelEvents(fn() => Transaction::factory(10000)->create());
    }
}
