<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker;

    public function run(): void
    {
        Event::fake();
        Transaction::factory(2000)->create();
    }
}
