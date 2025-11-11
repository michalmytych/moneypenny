<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Services\Transaction\PersonalAccount\SaldoService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;

class TransactionsTableSeeder extends Seeder
{
    use WithFaker;

    public function run(): void
    {
        Transaction::withoutEvents(function () {
            Transaction::factory(200)->create();
        });
    }
}
