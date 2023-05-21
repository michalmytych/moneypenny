<?php

namespace App\Services\Analysis;

use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use App\Services\Analysis\Analyzers\Analyzer;
use App\Contracts\Services\Analysis\AnalysisServiceContract;

/**
 * @deprecated
 */
class AnalysisService implements AnalysisServiceContract
{
    public function __construct(private readonly AnalyzerResolver $analyzerResolver) { }

    public function analyze(array $input): Collection
    {
        $analyzerAlias = data_get($input, 'analyzer_type');
        $analyzerClass = $this->getAnalyzerClassOrFail($analyzerAlias);

        /** @var Analyzer $analyzer */
        $analyzer = app($analyzerClass);

        try {
            return $analyzer->getResult();

        } catch (Throwable $throwable) {
            return $this->getErrorBag([
                'message' => "Error occurred while performing analysis with [$analyzerAlias] analyzer.",
                'details' => App::hasDebugModeEnabled() ? $throwable->getMessage() : 'Lacking permissions.',
            ]);
        }
    }

    private function getAnalyzerClassOrFail(string $analyzerAlias): string
    {
        $analyzerClass = $this->analyzerResolver->getAnalyzerByType($analyzerAlias);

        if (!$analyzerClass) {
            return $this->getErrorBag("Unknown analyzer alias: [$analyzerAlias]");
        }

        return $analyzerClass;
    }

    private function getErrorBag(string|array $message): Collection
    {
        return collect([
            'error' => $message,
        ]);
    }
}
