<?php

namespace App\Http\Controllers\Api\Transaction\Analytics;

use App\Models\Transaction\Category;
use App\Services\Analysis\Charts\BarChart;
use App\Services\Analysis\Charts\DoughnutChart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use App\Services\Analysis\Charts\DonutChart;
use App\Services\Analysis\Charts\LinearChart;
use App\Services\Transaction\Report\ReportService;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
    public function __construct(private readonly ReportService $reportService)
    {
    }

    public function index(Request $request): array
    {
        // @todo WTF ??????? REFACTOR
        $user = $request->user();
        $lastMonthDates = $this->getLastMonthDates();

        if ($request->input('chart_id') === 'lastMonthExpenditures') {
            $data = collect($lastMonthDates)->map(
                fn($dateString) => Transaction::query()
                    ->whereUser($user)
                    ->where('type', Transaction::TYPE_EXPENDITURE)
                    ->whereDate('transaction_date', Carbon::parse($dateString))
                    ->sum(Transaction::CALCULATION_COLUMN)
            );

            return BarChart::make(
                header: 'Expenditures total',
                labels: $lastMonthDates,
                data: $data->toArray(),
                dataBaseUrl: route('transaction.index')
            );
        }

        if ($request->input('chart_id') === 'categoriesPercentage') {
            $categories = Category::withCount('transactions')->get();
            $totalTransactionsCategorized = $categories->sum('transactions_count');

            $categoriesLabels = [];
            $categoriesValues = [];

            $categories
                ->each(function ($category) use ($totalTransactionsCategorized, &$categoriesLabels, &$categoriesValues) {
                    $categoriesLabels[] = Str::ucfirst($category->code);
                    $categoriesValues[] = $category->transactions_count / $totalTransactionsCategorized;
                });

            return DoughnutChart::make(
                header: ' Of category',
                labels: $categoriesLabels,
                data: $categoriesValues,
                dataBaseUrl: route('transaction.index')
            );
        }

        if ($request->input('chart_id') === 'expendituresAndIncomesTrend') {
            $data = $this
                ->reportService
                ->getAvgExpendituresByDays($user, sinceDate: now()->subMonth(), toDate: now());

            return LinearChart::make(
                header: 'Expenditures average trend',
                labels: $lastMonthDates,
                data: $data->pluck('total')->toArray(),
                dataBaseUrl: route('transaction.index')
            );
        }

        return [];
    }

    protected function getLastMonthDates(): array
    {
        $dates = [];

        $lastMonth = Carbon::now()->subMonth();
        $daysInLastMonth = $lastMonth->daysInMonth;

        for ($day = 1; $day <= $daysInLastMonth; $day++) {
            $date = $lastMonth->setDay($day)->format('d-m-Y');
            $dates[] = $date;
        }

        return $dates;
    }
}
