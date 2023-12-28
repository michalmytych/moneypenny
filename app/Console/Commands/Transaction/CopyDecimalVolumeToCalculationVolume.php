<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Transaction;

class CopyDecimalVolumeToCalculationVolume extends Command
{
    protected $signature = 'moneypenny:copy-decimal-volume-to-calculation-volume';

    protected $description = 'Copy decimal value transaction column to calculation volume column.';

    public function handle(): void
    {
        DB::transaction(function() {
            foreach (Transaction::cursor() as $transaction) {
                $transaction->update([
                    'calculation_volume' => $transaction->decimal_volume
                ]);
            }
        });
    }
}
