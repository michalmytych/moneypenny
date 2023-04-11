<?php

namespace App\Services\Helpers;

class TransactionHelper
{
    public static function rawVolumeToDecimal(string $volume): float
    {
        $volume  = str_replace(',', '.', $volume);
        $float = abs(floatval($volume));
        return round($float, 2);
    }

    public static function changeComaToDotAtRawVolume(string $rawVolume): string
    {
        return str_replace(',', '.', $rawVolume);
    }
}
