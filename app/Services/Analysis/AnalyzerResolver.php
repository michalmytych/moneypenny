<?php

namespace App\Services\Analysis;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Services\Analysis\Analyzers\Analyzer;

/**
 * @deprecated
 */
class AnalyzerResolver
{
    public function getAnalyzerByType(string $analysisType): ?string
    {
        $enabledAnalyzers = $this->getEnabledAnalyzersMapping();
        return data_get($enabledAnalyzers, $analysisType);
    }

    public function getEnabledAnalyzersMapping(): Collection
    {
        if (config('analyzers.use_auto_discovery')) {
            $config = $this->getAnalyzersByAutoDiscovery();
        } else {
            $config = config('analyzers.enabled');
        }

        return collect($config)
            ->mapWithKeys(fn($className) => [
                Str::snake(class_basename($className)) => $className,
            ]);
    }

    private function getAnalyzersByAutoDiscovery(): array
    {
        $analyzerPath    = app_path(config('analyzers.path'));
        $analyzerClasses = [];

        foreach (File::allFiles($analyzerPath) as $file) {
            $class     = str_replace('.php', '', $file->getFilename());
            $namespace = config('analyzers.namespace');
            $class     = "$namespace$class";

            if ($class !== Analyzer::class && is_subclass_of($class, Analyzer::class)) {
                $analyzerClasses[] = $class;
            }
        }

        return $analyzerClasses;
    }
}
