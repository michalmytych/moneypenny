<?php

namespace App\Http\Controllers;

use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Jobs\Persona\CreateTransactionPersonaAssociation;

class PersonaController extends Controller
{
    public function associatePersonasToTransactions(): string
    {
        foreach (Transaction::cursor() as $transaction) {
            CreateTransactionPersonaAssociation::dispatchSync(
                $transaction->id,
                $transaction->sender,
                $transaction->receiver
            );
        }

        $personasNames = Persona::all()->map(fn(Persona $persona) => $persona->common_name);

        return "Success <hr>" . $personasNames->implode("<br>") ;
    }
}
