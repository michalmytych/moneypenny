<?php

namespace App\Contracts\Services\Analysis;

use Illuminate\Support\Collection;

interface AnalysisServiceContract
{
    public function analyze(array $input): Collection;
}
