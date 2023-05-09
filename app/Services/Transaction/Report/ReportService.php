<?php

namespace App\Services\Transaction\Report;

use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Services\Transaction\Transformers\DateGroupByToCalendar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\Report\Defaults\MonthReport;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(private readonly CurrencyService $currencyService) {}

    /**
     * @param string|null $rawMonth Date in m-Y format (optional).
     * @param mixed $userId
     * @return array Report data.
     */
    public function getPeriodicReport(?string $rawMonth, mixed $userId): array
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

    public function getAvgExpendituresByDays(Carbon $sinceDate, Carbon $toDate): \Illuminate\Support\Collection|array
    {
        $expendituresData = Transaction::query()
            ->orderBy('transaction_date')
            ->where('type', Transaction::TYPE_EXPENDITURE)
            ->whereDate('transaction_date', '>=', $sinceDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->select(DB::raw('DATE(transaction_date) as date'), DB::raw('SUM(calculation_volume) as total'))
            ->groupBy('date')
            ->get();

        return DateGroupByToCalendar::transform($expendituresData);
    }

    private function getMonthReport(Carbon $carbon, Authenticatable $user): array
    {
        /** @var MonthReport $reportTemplate */
        $reportTemplate = app(MonthReport::class);

        return $reportTemplate
            ->setParams(['selected_month' => $carbon])
            ->getReportData($user);
    }

    public function getAvgIncomesByDays(Carbon $sinceDate, Carbon $toDate): Collection|array
    {
        $incomesData = Transaction::query()
            ->orderBy('transaction_date')
            ->where('type', Transaction::TYPE_INCOME)
            ->whereDate('transaction_date', '>=', $sinceDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->select(DB::raw('DATE(transaction_date) as date'), DB::raw('SUM(calculation_volume) as total'))
            ->groupBy('date')
            ->get();

        return DateGroupByToCalendar::transform($incomesData);
    }
}
