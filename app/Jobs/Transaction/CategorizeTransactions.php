<?php

namespace App\Jobs\Transaction;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use hisorange\BrowserDetect\Exceptions\Exception;
use App\Services\Transaction\Categorize\TransactionCategorizeService;

class CategorizeTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public array $transactionsIds)
    {
    }

    /**
     * Execute the job.
     *
     * @throws       Exception
     * @noinspection PhpUndefinedMethodInspection
     */
    public function handle(TransactionCategorizeService $transactionCategorizeService): void
    {
        $transactions = Transaction::whereIn('id', $this->transactionsIds)->get();
        $transactionCategorizeService->categorizeTransactions($transactions);
    }
}
