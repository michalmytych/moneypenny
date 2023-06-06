<?php

namespace App\Services\Analytics\Charts;

class BarChart extends Chart
{
    public static function make(string $header, array $labels, array $data, string $dataBaseUrl = null): array
    {
        // @todo add baseConfig property to Chart so u can do here: $this->baseConfig + [<config>]
        return [
            'config' => [
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => $header,
                            'data' => $data,
                            'fill' => true,
                            'backgroundColor' => '#6366F1',
                        ]
                    ]
                ],
                'type' => 'bar',
                'dataBaseUrl' => $dataBaseUrl
            ]
        ];
    }
}
