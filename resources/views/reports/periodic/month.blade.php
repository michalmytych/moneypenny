<x-app-layout>
    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="container mx-auto my-8">
                <div class="flex justify-between">
                    <h1 class="text-3xl font-bold mb-4">
                        {{ __('Month report') }}
                    </h1>
                    <form id="monthForm" action="{{ route('report.periodic') }}" method="get">
                        <input class="rounded" type="month" name="month" id="month">
                    </form>
                </div>
                <div class="grid lg:grid-cols-2 gap-4 mb-4 md:grid-cols-1 md:gap-8 sm:grid-cols-1">
                    <div class="pb-2 pr-4 rounded-lg pl-0.5 pt-4">
                        <h2 class="text-2xl font-bold mb-2">{{ __('Summary') }}</h2>
                        <ul>
                            <li class="flex justify-between items-end">
                                <span class="text-lg font-light text-gray-600">{{ __('Transactions count') }}</span>
                                <span class="text-4xl font-semibold">
                                    {{ $data['transactions_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between items-end">
                                <span class="text-lg font-light text-gray-600">{{ __('Expenditures count') }}</span>
                                <span class="text-4xl font-semibold">
                                    {{ $data['expenditures_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between items-end">
                                <span class="text-lg font-light text-gray-600">{{ __('Incomes count') }}</span>
                                <span class="text-4xl font-semibold">
                                    {{ $data['incomes_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between items-end">
                                <span class="text-lg font-light text-gray-600">{{ __('Expenditures sum') }}</span>
                                <span class="text-4xl font-semibold">
                                    {{ $data['expenditures_sum'] }}
                                    <span class="text-xl font-lighter">
                                        {{ $data['currency'] }}
                                    </span>
                                </span>
                            </li>
                            <li class="flex justify-between items-end">
                                <span class="text-lg font-light text-gray-600">{{ __('Incomes count') }}</span>
                                <span class="text-4xl font-semibold">
                                    {{ $data['incomes_sum'] }}
                                    <span class="text-xl font-lighter">
                                        {{ $data['currency'] }}
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2 px-4 mt-2">{{ __('Highest incomes') }}</h2>
                        <table class="w-full">
                            <thead>
                            <tr>
                                <th class="px-4 text-left">{{ __('Date') }}</th>
                                <th class="px-4 text-left">{{ __('Description') }}</th>
                                <th class="px-4 text-left">{{ __('Volume') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['top_5_biggest_incomes'] as $income)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($income['transaction_date'])->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">{{ \App\Shared\Helpers\StringHelper::shortenAuto($income['description']) }}</td>
                                    <td class="px-4 py-2">{{ $income['calculation_volume'] }} {{ $data['currency'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2 px-4 mt-2">{{ __('Highest expenses') }}</h2>
                        <table class="w-full">
                            <thead>
                            <tr>
                                <th class="px-4 text-left">{{ __('Date') }}</th>
                                <th class="px-4 text-left">{{ __('Description') }}</th>
                                <th class="px-4 text-left">{{ __('Volume') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['top_5_biggest_expenditures'] as $expenditure)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($expenditure['transaction_date'])->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">{{ \App\Shared\Helpers\StringHelper::shortenAuto($expenditure['description']) }}</td>
                                    <td class="px-4 py-2">{{ $expenditure['calculation_volume'] }} {{ $data['currency'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2 px-4 mt-2">{{ __('Trend of average daily expenditures and incomes') }}</h2>
                        @include('charts.linear')
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            const monthForm = document.getElementById('monthForm');
            const monthInput = monthForm.querySelector('#month');

            const date = new Date();
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            monthInput.value = `${year}-${month}`;

            monthInput.addEventListener('change', () => {
                monthForm.submit();
            });
        });
    </script>
</x-app-layout>
