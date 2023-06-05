<?php

namespace App\Services\Analysis\Charts;

class DoughnutChart extends Chart
{
    public static function make(string $header, array $labels, array $data, string $dataBaseUrl = null): array
    {
        // @todo add baseConfig property to Chart so u can do here: $this->baseConfig + [<config>]
        $colors = [];
        foreach ($data as $value) {

        }

        return [
            'config' => [
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => $header,
                            'data' => $data,
                            'fill' => true,
                            'backgroundColor' => self::generateColors(count($data)),
                        ]
                    ]
                ],
                'type' => 'doughnut',
                'dataBaseUrl' => $dataBaseUrl
            ]
        ];
    }

    private static function generateColors(int $count): array
    {
        $colors = [];

        $baseColor = '#4F46E5';
        $baseRgb = sscanf($baseColor, "#%02x%02x%02x");

        for ($i = 1; $i <= $count; $i++) {
            $randomizedRgb = array_map(function ($value) {
                $randomValue = mt_rand(-100, 100);
                $newValue = $value + $randomValue;

                return max(0, min(255, $newValue));
            }, $baseRgb);

            $newColor = sprintf("#%02x%02x%02x", ...$randomizedRgb);
            $colors[] = $newColor;
        }

        return $colors;
    }
}
