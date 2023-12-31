<?php

namespace App\Moneypenny\Transaction\Jobs;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\Categorize\TransactionCategorizeService;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CategorizeTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public array $transactionsIds)
    {
    }

    /**
     * Execute the job.
     * @throws Exception
     * @noinspection PhpUndefinedMethodInspection
     */
    public function handle(TransactionCategorizeService $transactionCategorizeService): void
    {
        $transactions = Transaction::whereIn('id', $this->transactionsIds)->get();
        $transactionCategorizeService->categorizeTransactions($transactions);
    }
}
