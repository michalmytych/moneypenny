<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Import\ColumnsMapping;

class ColumnsMappingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // @todo ASAP - rm this hack (looping users)
        foreach (User::cursor() as $user) {

            ColumnsMapping::create([
                'user_id' => $user->id,
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
}
