<?php

namespace Database\Seeders;

use App\Models\Import\ColumnsMapping;
use Illuminate\Database\Seeder;

class ColumnsMappingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColumnsMapping::create([
            'name'                          => 'Alior Export',
            'transaction_date_column_index' => 0,
            'accounting_date_column_index'  => 1,
            'sender_column_index'           => 2,
            'receiver_column_index'         => 3,
            'description_column_index'      => 4,
            'volume_column_index'           => 5,
            'currency_column_index'         => 6,
        ]);
    }
}
