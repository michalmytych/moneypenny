<?php

namespace Database\Seeders;

use App\Moneypenny\Import\Models\ColumnsMapping;
use App\Moneypenny\User\Models\User;
use Illuminate\Database\Seeder;

class ColumnsMappingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColumnsMapping::create([
            'user_id' => User::first()->id,
            'name' => 'Alior Export',
            'transaction_date_column_index' => 0,
            'accounting_date_column_index' => 1,
            'sender_column_index' => 2,
            'receiver_column_index' => 3,
            'description_column_index' => 4,
            'volume_column_index' => 5,
            'currency_column_index' => 6,
            'sender_account_number_column_index' => 9,
            'receiver_account_number_column_index' => 10,
        ]);
    }
}
