<?php

namespace App\Services\Analysis\Charts;

abstract class Chart
{
    abstract public static function make(string $header, array $labels, array $data, string $dataBaseUrl = null): array;
}
