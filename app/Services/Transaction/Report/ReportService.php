<?php

namespace App\Services\Transaction\Report;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Transaction\Report\Defaults\MonthReport;

class ReportService
{
    public function getMonthReport(Carbon $carbon, Authenticatable $user): array
    {
        /** @var MonthReport $reportTemplate */
        $reportTemplate = app(MonthReport::class);

        return $reportTemplate
            ->setParams(['selected_month' => $carbon])
            ->getReportData($user);
    }
}
