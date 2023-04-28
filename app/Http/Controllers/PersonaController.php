<?php

namespace App\Http\Controllers;

use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\TransactionPersonaService;

class PersonaController extends Controller
{
    /** @noinspection PhpUndefinedMethodInspection */
    public function associatePersonasToTransactions(): string
    {
        foreach (Transaction::cursor() as $transaction) {
            app(TransactionPersonaService::class)->createPersonasAssociations($transaction);
        }

        $personasCount = Persona::count();

        return "Successfuly associated. Personas count: $personasCount";
    }
}
