<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Persona;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\TransactionPersonaService;

class PersonaController extends Controller
{
    public function __construct(private readonly TransactionPersonaService $transactionPersonaService) {}

    public function index(Request $request): View
    {
        $selectedPersonaId = $request->get('selected_persona_id');

        $personas = Persona::withCount('transactionsAsSender', 'transactionsAsReceiver')
            ->latest()
            ->get();

        if (null !== $selectedPersonaId) {
            return view('persona.index', [
                'personas' => $personas,
                'selected_persona' => Persona::with(
                    'transactionsAsSender', 'transactionsAsReceiver'
                )
                    ->find($selectedPersonaId)
            ]);
        }

        return view('persona.index', [
            'personas' => $personas,
        ]);
    }

    public function update(Persona $persona, Request $request): RedirectResponse
    {
        $persona->update($request->all());
        return redirect()->back();
    }

    public function associatePersonasToTransactions(): string
    {
        foreach (Transaction::cursor() as $transaction) {
            $this->transactionPersonaService->createPersonasAssociations($transaction);
        }

        return redirect(route('persona.index'));
    }
}
