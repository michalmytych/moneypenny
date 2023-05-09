<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use App\Jobs\Transaction\GenerateMonthlyRaport;

class GenerateReports extends Command
{
    protected $signature = 'moneypenny:generate-reports';

    protected $description = 'Generate reports for currently stored transactions.';

    public function handle(): void
    {
        $month = now();

        while (true) {
            $formattedMonth = $month->format('m-Y');
            GenerateMonthlyRaport::dispatch($formattedMonth);
            $month = now()->addMonth();
        }
    }
}
