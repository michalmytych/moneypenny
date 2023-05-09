<?php

namespace App\Http\Controllers;

use App\Services\Transaction\Currency\CurrencyService;
use Illuminate\Http\Request;
use App\Services\Transaction\Report\ReportService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService   $reportService,
        private readonly CurrencyService $currencyService
    )
    {
    }

    public function index(): string
    {
        return 'Hello!';
    }

    public function periodic(Request $request): View
    {
        $rawMonth = $request->input('month');

        if ($rawMonth) {
            $carbon = Carbon::createFromFormat('Y-m', $rawMonth);
        } else {
            $carbon = now();
        }

        $cacheKey = $carbon->format('Y_m') . '_periodic_report_' . $request->user()?->id;

        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);

        } else {
            $data = $this->reportService->getMonthReport($carbon, Auth::user());
            $data['currency'] = $this->currencyService->resolveCalculationCurrency();
            Cache::put($cacheKey, $data, 10);
        }

        return view('reports.periodic.month', compact('data'));
    }
}
