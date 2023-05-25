<?php

namespace App\Services\Analysis\Charts;

class LinearChart extends Chart
{
    public static function make(string $header, array $labels, array $data, string $dataBaseUrl = null): array
    {
        return [
            'config' => [
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => $header,
                            'data' => $data,
                            'fill' => false,
                            'borderColor' => '#6366F1',
                            'tension' => 0.1,
                            'pointRadius' => 10,
                        ]
                    ]
                ],
                'type' => 'line',
                'point' => [
                    'radius' => 100,
                    'hoverRadius' => 500
                ],
                'dataBaseUrl' => $dataBaseUrl
            ]
        ];
    }
}
