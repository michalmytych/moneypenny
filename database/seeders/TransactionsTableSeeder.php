<?php

namespace Database\Seeders;

use App\Moneypenny\Transaction\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker, WithoutModelEvents;

    public function run(): void
    {
        $this->withoutModelEvents(fn() => Transaction::factory(10000)->create());
    }
}
