<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnsMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date_column_index',
        'accounting_date_column_index',
        'sender_column_index',
        'receiver_column_index',
        'description_column_index',
        'currency_column_index'
    ];
}
