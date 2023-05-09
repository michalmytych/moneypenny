<?php

namespace App\Services\Transaction\Report;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\Report\Defaults\MonthReport;

class ReportService
{
    public function __construct(private readonly CurrencyService $currencyService) {}

    /**
     * @param string $rawMonth Date in m-Y format.
     * @return array Report data.
     */
    public function getPeriodicReport(string $rawMonth, mixed $userId): array
    {
        if ($rawMonth) {
            $carbon = Carbon::createFromFormat('Y-m', $rawMonth);
        } else {
            $carbon = now();
        }

        $cacheKey = $carbon->format('Y_m') . '_periodic_report_' . $userId;

        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);

        } else {
            $user = User::findOrFail($userId);
            $data = $this->getMonthReport($carbon, $user);
            $data['currency'] = $this->currencyService->resolveCalculationCurrency();
            Cache::put($cacheKey, $data, 10);
        }

        return $data;
    }

    private function getMonthReport(Carbon $carbon, Authenticatable $user): array
    {
        /** @var MonthReport $reportTemplate */
        $reportTemplate = app(MonthReport::class);

        return $reportTemplate
            ->setParams(['selected_month' => $carbon])
            ->getReportData($user);
    }
}
