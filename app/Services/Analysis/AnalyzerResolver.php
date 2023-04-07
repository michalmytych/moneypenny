<?php

namespace App\Services\Analysis;

use App\Services\Analysis\Analyzers\TransactionCountPerDay;
use App\Services\Analysis\Analyzers\TransactionVolumeSumPerDay;

class AnalyzerResolver
{
    /**
     *      ADDING NEW ANALYZER EXTENSION
     *
     *      1. Extend Analyzer abstract class.
     *      2. Add extension to ANALYSIS_TYPE_TO_ANALYZER_MAPPING using snake_case for key.
     *      3. Implement required methods at yours Analyzer extension.
     *      4. Make sure you formatted output data correctly:
     *          - "chart_type" - e.g. "linear"
     *          - "data" - data in format required by chart
     */

    private const ANALYSIS_TYPE_TO_ANALYZER_MAPPING = [
        'transaction_count_per_day'      => TransactionCountPerDay::class,
        'transaction_volume_sum_per_day' => TransactionVolumeSumPerDay::class,
    ];

    public function getAnalyzerByType(string $analysisType): ?string
    {
        return data_get(self::ANALYSIS_TYPE_TO_ANALYZER_MAPPING, $analysisType);
    }
}
