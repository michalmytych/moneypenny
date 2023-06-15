@if(count($imports) > 0)
    <div class="p-4">
        <h2 class="text-3xl font-bold mb-4">{{ __('Transactions imports') }}</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Status') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Source') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Stats') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Created at') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($imports as $import)
                <tr class="divide-y divide-gray-200">
                    <td class="px-4 py-2">
                        @if ($import->status === \App\Models\Import\Import::STATUS_PROCESSING)
                            {{ __('Processing') }}
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_SAVED)
                            {{ __('Saved') }}
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORTING)
                            {{ __('Importing') }}
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORTED)
                            {{ __('Imported') }}
                        @elseif ($import->status === \App\Models\Import\Import::STATUS_IMPORT_ERROR)
                            {{ __('Import failed') }}
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($import->file_id || $import->synchronization_id)
                            @if($import->file_id)
                                <span class="font-semibold text-gray-500">
                                    {{ __('File') }}
                                    <br>
                                </span>
                                <span>{{ $import->file->name }}</span>
                            @endif
                            @if($import->synchronization_id)
                                <span class="font-semibold text-gray-500">
                                    {{ __('Synchronization') }}
                                    <br>
                                </span>
                                <span>{{ $import->synchronization->created_at->format('d.m.Y H:i') }}</span>
                            @endif
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-gray-500 font-semibold">{{ __('Added transactions') }}: </span>
                        <span class="text-black font-semibold">{{ $import->added_transactions_count }}</span>
                        <br>
                        <span class="text-gray-500 font-semibold">{{ __('Skipped transactions') }}: </span>
                        <span class="text-black font-semibold">{{ $import->transactions_skipped_count }}</span>
                    </td>
                    <td class="px-4 py-2">{{ $import->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-2xl">{{ __('No imports') }}</h2>
    <p class="mt-4">
        {{ __('Add first') }}
        <a class="text-indigo-600 font-semibold hover:text-indigo-400" href="{{ route('institution.index') }}"> {{ __('bank integration') }} </a>
        {{ __('or') }}
        <a class="text-indigo-600 font-semibold hover:text-indigo-400" href="{{ route('file.index') }}"> {{ __('upload transaction file') }}</a>.
    </p>
@endif
