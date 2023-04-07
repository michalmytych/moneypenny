<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TYPE_UNKNOWN     = 0;
    const TYPE_INCOME      = 1;
    const TYPE_EXPENDITURE = 2;

    protected $fillable = [
        'transaction_date',
        'accounting_date',
        'decimal_volume',
        'raw_volume',
        'sender',
        'volume',
        'receiver',
        'description',
        'currency',
    ];
}
