@if(count($imports) > 0)
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-4">Lista Importów</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Żródło
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statystyki
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Data utworzenia
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($imports as $import)
                <tr>
                    <td class="px-4 py-2">{{ $import->id }}</td>
                    <td class="px-4 py-2">
                        @if ($import->status === \App\Models\Import\Import::STATUS_PROCESSING)
                            Przetwarzanie
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_SAVED)
                            Zapisany
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORTING)
                            Importowanie
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORTED)
                            Zaimportowany
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORT_ERROR)
                            Błąd importu
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($import->file_id || $import->synchronization_id)
                            @if($import->file_id)
                                <span class="font-semibold">Plik<br></span>
                                <span class="text-gray-500">{{ $import->file->name }}</span>
                            @endif
                            @if($import->synchronization_id)
                                <span class="text-gray-500">
                                    <span class="font-semibold">Synchronizacja<br></span>
                                    {{ $import->synchronization->created_at->format('d.m.Y H:i') }}
                                </span>
                            @endif
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-gray-500 font-semibold">Dodane transakcje: </span>
                        <span class="text-black font-semibold">{{ $import->added_transactions_count }}</span>
                        <br>
                        <span class="text-gray-500 font-semibold">Pominięte transakcje: </span>
                        <span class="text-black font-semibold">{{ $import->transactions_skipped_count }}</span>
                    </td>
                    <td class="px-4 py-2">{{ $import->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">Brak importów</h2>
@endif
