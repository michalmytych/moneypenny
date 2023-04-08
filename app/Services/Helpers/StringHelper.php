<?php

namespace App\Services\Helpers;

class StringHelper
{
    public static function shortenAuto(mixed $value, int $length = 20): string
    {
        $value = (string) $value;

        if (strlen($value) > $length) {
            $str = substr($value, 0, $length);
            return rtrim($str) . '...';
        }

        return $value;
    }
}
