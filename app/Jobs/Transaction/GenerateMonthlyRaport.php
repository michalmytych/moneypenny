<?php

namespace App\Jobs\Transaction;

use App\Services\Transaction\Report\ReportBuilder;
use App\Services\Transaction\Report\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateMonthlyRaport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $month)
    {
        //
    }

    public function handle(ReportBuilder $reportBuilder, ReportService $reportService): void
    {
        $reportBuilder
            ->addField('Costs this month', $reportService->get)
            ->addField('Costs this month', 1000)
            ->build();
    }
}
