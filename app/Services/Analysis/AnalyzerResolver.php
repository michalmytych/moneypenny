<?php

namespace App\Services\Analysis;

use Illuminate\Support\Str;

class AnalyzerResolver
{
    public function getAnalyzerByType(string $analysisType): ?string
    {
        $config = config('analyzers.enabled');

        $enabledAnalyzers = collect($config)
            ->mapWithKeys(fn($className) => [
                Str::snake(class_basename($className)) => $className
            ]);

        return data_get($enabledAnalyzers, $analysisType);
    }
}
