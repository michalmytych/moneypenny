@if(count($imports) > 0)
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-4">Lista Importów</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa pliku</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data utworzenia</th>
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
                        <td class="px-4 py-2">{{ $import->file->name }}</td>
                        <td class="px-4 py-2">{{ $import->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">Brak importów</h2>
@endif
