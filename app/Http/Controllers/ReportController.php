<?php

namespace App\Http\Controllers;

use App\Services\Transaction\Currency\CurrencyService;
use Illuminate\Http\Request;
use App\Services\Transaction\Report\ReportService;
use Illuminate\Support\Carbon;
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

        $data = $this->reportService->getMonthReport($carbon);

        $data['currency'] = $this->currencyService->resolveCalculationCurrency();

        return view('reports.periodic.month', compact('data'));
    }
}
