<?php

namespace App\Moneypenny\Transaction\Http\Controller\Api;

use App\Shared\Http\Controller\Controller;
use App\Transaction\Report\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function avgExpenditures(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this
            ->reportService
            ->getAvgExpendituresByDays($user, sinceDate: now()->subMonth(), toDate: now());

        return response()->json([
            'dataset' => $data
        ]);
    }

    public function avgIncomes(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this
            ->reportService
            ->getAvgIncomesByDays($user, sinceDate: now()->subMonth(), toDate: now());

        return response()->json([
            'dataset' => $data
        ]);
    }
}
