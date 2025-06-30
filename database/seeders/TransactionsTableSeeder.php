<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker;

    public function run(): void
    {
        Event::fake();
        Transaction::factory(100)->create([
            'user_id' => User::where('is_admin', true)->limit(1)->get()->first()->id,
        ]);
        Transaction::factory(2000)->create();
    }
}
