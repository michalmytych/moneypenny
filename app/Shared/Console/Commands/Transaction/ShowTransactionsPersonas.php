<?php

namespace App\Shared\Console\Commands\Transaction;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Shared\Helpers\StringHelper;
use Illuminate\Console\Command;

class ShowTransactionsPersonas extends Command
{
    protected $signature = 'moneypenny:show-transactions-personas';

    protected $description = 'Print all transactions with associated personas.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $transactionsPersonasData = $this->performTask();

        $transactionsCount = Transaction::count();
        $this->line("<fg=blue>Creating associations for $transactionsCount transactions...</>");
        $this->line("* * * * * * * * * * * * * * * * * * * * * * *");

        $this->info('Transactions personas list:');

        $this->table(
            ['ID', 'Sender persona', 'Receiver persona'],
            $transactionsPersonasData
        );
    }

    private function performTask(): array
    {
        $transactionsCursor = Transaction::cursor();
        $transactionsPersonasData = [];

        foreach ($transactionsCursor as $transaction) {
            /** @var Transaction $transaction */
            $spCommonName = $transaction->senderPersona?->common_name ?? '';
            $rpCommonName = $transaction->receiverPersona?->common_name ?? '';
            $sender = $transaction->sender ?? '';
            $receiver = $transaction->receiver ?? '';

            $transactionsPersonasData[] = [
                'id' => $transaction->id,
                'sender' => trim(StringHelper::shortenAuto($sender, 25)),
                'sender_persona_common_name' => trim(StringHelper::shortenAuto($spCommonName, 25)),
                'receiver' => trim(StringHelper::shortenAuto($receiver, 25)),
                'receiver_persona_common_name' => trim(StringHelper::shortenAuto($rpCommonName, 25)),
            ];
        }

        return $transactionsPersonasData;
    }
}
