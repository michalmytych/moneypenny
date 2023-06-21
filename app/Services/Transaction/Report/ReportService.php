<?php

namespace App\Services\Transaction\Report;

use App\Models\Transaction\Report;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\Report\Defaults\MonthReport;
use App\Services\Transaction\Transformers\DateGroupByToCalendar;

class ReportService
{
    public function __construct(private readonly CurrencyService $currencyService)
    {
    }

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
            $data['currency'] = $this->currencyService->resolveCalculationCurrency($user);
            Cache::put($cacheKey, $data, 10);
        }

        return $data;
    }

    public function getAvgExpendituresByDays(User $user, Carbon $sinceDate, Carbon $toDate): Collection|array
    {
        $expendituresData = $this
            ->getBaseTrendQuery($user)
            ->where('type', Transaction::TYPE_EXPENDITURE)
            ->whereDate('transaction_date', '>=', $sinceDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->get();

        return DateGroupByToCalendar::transform($expendituresData, 'transaction_date', 'average_volume');
    }

    private function getMonthReport(Carbon $carbon, User $user): array
    {
        /** @var MonthReport $reportTemplate */
        $reportTemplate = app(MonthReport::class);

        return $reportTemplate
            ->setParams(['selected_month' => $carbon])
            ->getReportData($user);
    }

    public function getAvgIncomesByDays(User $user, Carbon $sinceDate, Carbon $toDate): Collection|array
    {
        $incomesData = $this
            ->getBaseTrendQuery($user)
            ->where('type', Transaction::TYPE_INCOME)
            ->whereDate('transaction_date', '>=', $sinceDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->get();

        return DateGroupByToCalendar::transform($incomesData, 'transaction_date', 'average_volume');
    }

    protected function getBaseTrendQuery(User $user): Builder
    {
        return Transaction::whereUser($user)
            ->select(DB::raw('transaction_date'),
                DB::raw('SUM(calculation_volume) as daily_sum'),
                DB::raw('AVG(SUM(calculation_volume)) OVER (ORDER BY transaction_date ASC ROWS BETWEEN UNBOUNDED PRECEDING AND 1 PRECEDING) as average_volume'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'ASC');
    }
}
