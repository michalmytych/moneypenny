<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Transaction\Report\ReportService;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService)
    {
    }

    public function avgExpenditures(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this
            ->reportService
            ->getAvgExpendituresByDays($user, sinceDate: now()->subMonth(), toDate: now());

        return response()->json(
            [
            'dataset' => $data
            ]
        );
    }

    public function avgIncomes(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this
            ->reportService
            ->getAvgIncomesByDays($user, sinceDate: now()->subMonth(), toDate: now());

        return response()->json(
            [
            'dataset' => $data
            ]
        );
    }
}
