<?php

namespace App\Console\Commands\Transaction;

use App\Models\Transaction\Transaction;
use Illuminate\Console\Command;

class UpdateTypesBasedOnRawVolume extends Command
{
    protected $signature = 'moneypenny:update-types';

    protected $description = 'Update transactions types based on raw volume column.';

    public function handle(): void
    {
        $this->withProgressBar(Transaction::cursor(), function(Transaction $transaction) {
            $rawVolume = $transaction->raw_volume;

            if (str_starts_with($rawVolume, '-')) {
                $transaction->update(['type' => Transaction::TYPE_EXPENDITURE]);
            } else {
                $transaction->update(['type' => Transaction::TYPE_INCOME]);
            }
        });

        $this->info(PHP_EOL . 'Transactions types updated successfully.');
    }
}
