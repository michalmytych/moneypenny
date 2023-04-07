<?php

namespace App\Services\Analysis\Analyzers;

use Illuminate\Support\Collection;

abstract class Analyzer
{
    abstract protected function runQuery(): Collection;

    abstract protected function formatDataForChart($queryResult): Collection;

    public function getResult(): Collection
    {
        $queryResult = $this->runQuery();

        return $this->formatDataForChart($queryResult);
    }
}
