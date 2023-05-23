@if(count($exchangeRates) > 0)
    <h2 class="text-3xl font-semibold mb-4">{{ __('Historical currencies exchange rates') }}</h2>
    <table class="w-full divide-y divide-gray-200 overflow-x-scroll">
        <thead class="bg-gray-50 rounded-t-md">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Rate') }}
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Source currency') }}
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Target currency') }}
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Date') }}
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 overflow-x-scroll">
        @foreach ($exchangeRates as $exchangeRate)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $exchangeRate->rate }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $exchangeRate->base_currency }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $exchangeRate->target_currency }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $exchangeRate->rate_source_date->format('d.m.Y') }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h2 class="font-semibold text-xl">{{ __('No exchange rates') }}</h2>
@endif
