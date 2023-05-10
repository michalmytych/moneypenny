<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use App\Models\Transaction\Persona;
use App\Services\Helpers\StringHelper;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\TransactionPersonaService;

class AssociatePersonasToTransactions extends Command
{
    protected $signature = 'moneypenny:associate-personas';

    protected $description = 'Create personas associations for all transactions.';

    /** @noinspection PhpUndefinedMethodInspection */
    public function handle(): void
    {
        $transactionsCount = Transaction::count();

        $this->line("<fg=blue>Creating associations for $transactionsCount transactions...</>");
        $this->line("* * * * * * * * * * * * * * * * * * * * * * *");

        $this->withProgressBar(Transaction::cursor(), function (Transaction $transaction) {
            $this->performTask($transaction);
        });

        $this->info(PHP_EOL . 'Found personas list:');

        $personasData = [];
        $personas = Persona::withCount('transactionsAsSender', 'transactionsAsReceiver')->get();

        foreach ($personas as $persona) {
            /** @var Persona $persona */
            $associatedNamesCount = count(json_decode($persona->associated_names, true));
            $commonNameOutput = trim(StringHelper::shortenAuto($persona->common_name, 25));
            $associatedNamesOutput = "$associatedNamesCount : ";
            $associatedNamesOutput .= trim(StringHelper::shortenAuto($persona->associated_names, 45));
            $accountNumberOutput = $persona->account_number;

            /** @noinspection PhpUndefinedFieldInspection */
            $personasData[] = [
                'common_name' => $commonNameOutput,
                'associated_names' => $associatedNamesOutput,
                'account_number' => $accountNumberOutput,
                'transactions_as_sender' => $persona->transactions_as_sender_count,
                'transactions_as_receiver' => $persona->transactions_as_receiver_count,
            ];
        }

        $this->table(
            ['Common name', 'Associated names', 'Account number', 'Transactions as sender', 'Transactions as receiver'],
            $personasData
        );

        $personasCount = Persona::count();
        $this->info("Successfuly associated. Personas count: $personasCount");
    }

    private function performTask(Transaction $transaction): void
    {
        app(TransactionPersonaService::class)->createPersonasAssociations($transaction);
    }
}
