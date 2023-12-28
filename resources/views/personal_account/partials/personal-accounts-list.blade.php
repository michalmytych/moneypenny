@if(count($personalAccounts) > 0)
    <div class="p-4">
        <h2 class="text-3xl font-bold mb-4">{{ __('Personal accounts') }}</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Name') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Transactions count') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Created at') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($personalAccounts as $personalAccount)
                <tr class="divide-y divide-gray-200">
                    <td class="px-4 py-2">
                        {{ $personalAccount->name }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $personalAccount->transactions_count }}
                    </td>
                    <td class="px-4 py-2">{{ $personalAccount->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-2xl">{{ __('No personal accounts') }}</h2>
@endif
