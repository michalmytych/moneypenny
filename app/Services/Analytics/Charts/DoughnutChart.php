<?php

namespace App\Services\Analytics\Charts;

use App\Services\Analytics\Charts\Traits\UseGenerateSimilarColors;

class DoughnutChart extends Chart
{
    use UseGenerateSimilarColors;

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
                            'backgroundColor' => self::generateColors(count($data)),
                        ]
                    ]
                ],
                'type' => 'doughnut',
                'dataBaseUrl' => $dataBaseUrl
            ]
        ];
    }
}
