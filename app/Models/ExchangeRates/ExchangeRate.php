<?php

namespace App\Models\ExchangeRates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method   static where(string[] $criteria)
 * @method   static whereDate(string $string, string $format)
 * @method   static create(array $array)
 * @method   static latest()
 * @property string $rate
 */
class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'base_currency',
        'target_currency',
        'rate_source_date'
    ];

    protected $casts = [
        'rate_source_date' => 'date'
    ];
}
