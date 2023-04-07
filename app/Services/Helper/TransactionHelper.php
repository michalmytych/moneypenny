<?php

namespace App\Services\Helper;

class TransactionHelper
{
    public static function rawVolumeToDecimal(string $volume): float
    {
        $volume  = str_replace(',', '.', $volume);
        $float = abs(floatval($volume));
        return round($float, 2);
    }
}
