<?php

namespace App\Services\Helpers;

use App\Models\Transaction\Transaction;

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

    public static function createRawVolume(float $decimalVolume, int $type): string
    {
        if ($type === Transaction::TYPE_EXPENDITURE) {
            return "-$decimalVolume";
        }

        if ($type === Transaction::TYPE_INCOME) {
            return "$decimalVolume";
        }

        return "";
    }
}
