<?php

namespace App\Services\Analytics\Charts\Traits;

trait UseGenerateSimilarColors
{
    protected static function getBaseRGBValues(): mixed
    {
        return sscanf('#4F46E5', "#%02x%02x%02x");
    }

    protected static function generateColors(int $count): array
    {
        $colors = [];

        for ($i = 1; $i <= $count; $i++) {
            $colors[] = self::generateRandomColor();
        }

        return $colors;
    }

    protected static function generateRandomColor(): string
    {
        $randomizedRgb = array_map(function ($value) {
            $randomValue = mt_rand(-100, 100);
            $newValue = $value + $randomValue;
            return max(0, min(255, $newValue));
        }, self::getBaseRGBValues());

        return sprintf("#%02x%02x%02x", ...$randomizedRgb);
    }
}
