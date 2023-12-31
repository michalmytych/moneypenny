<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Http\Controllers\Controller;
use App\Moneypenny\Persona\Models\Persona;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\Transaction\TransactionPersonaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function __construct(private readonly TransactionPersonaService $transactionPersonaService) {}

    public function index(Request $request): View
    {
        // @todo - not working logic (user)
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
        // @todo - not working logic (user)
        $persona->update($request->all());

        return redirect()->back();
    }

    public function associatePersonasToTransactions(): string
    {
        // @todo - not working logic (user)
        foreach (Transaction::cursor() as $transaction) {
            $this->transactionPersonaService->createPersonasAssociations($transaction);
        }

        return to_route('persona.index');
    }
}
