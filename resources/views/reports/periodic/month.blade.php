<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="container mx-auto my-8">
                <div class="flex justify-between">
                    <h1 class="text-3xl font-bold mb-4">Raport finansowy</h1>
                    <form id="monthForm" action="{{ route('report.periodic') }}" method="get">
                        <input class="rounded" type="month" name="month" id="month">
                    </form>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-200 p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2">Podsumowanie</h2>
                        <ul>
                            <li class="flex justify-between">
                                <span class="text-lg font-light text-gray-600">Liczba transakcji</span>
                                <span class="text-xl font-semibold">
                                    {{ $data['transactions_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-lg font-light text-gray-600">Liczba wydatków</span>
                                <span class="text-xl font-semibold">
                                    {{ $data['expenditures_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-lg font-light text-gray-600">Liczba wpływów</span>
                                <span class="text-xl font-semibold">
                                    {{ $data['incomes_count'] }}
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-lg font-light text-gray-600">Suma wydatków</span>
                                <span class="text-xl font-semibold">
                                    {{ $data['expenditures_sum'] }} {{ $data['currency'] }}
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-lg font-light text-gray-600">Suma wpływów</span>
                                <span class="text-xl font-semibold">
                                    {{ $data['incomes_sum'] }} {{ $data['currency'] }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-200 p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2">Największe przychody</h2>
                        <table class="w-full">
                            <thead>
                            <tr>
                                <th class="text-left">Data transakcji</th>
                                <th class="text-left">Opis</th>
                                <th class="text-left">Kwota</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['top_5_biggest_incomes'] as $income)
                                <tr>
                                    <td class="border px-4 py-2">{{ \Illuminate\Support\Carbon::parse($income['transaction_date'])->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ \App\Services\Helpers\StringHelper::shortenAuto($income['description']) }}</td>
                                    <td class="border px-4 py-2">{{ $income['calculation_volume'] }} {{ $data['currency'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-200 p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-2">Największe wydatki</h2>
                        <table class="w-full">
                            <thead>
                            <tr>
                                <th class="text-left">Data transakcji</th>
                                <th class="text-left">Opis</th>
                                <th class="text-left">Kwota</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['top_5_biggest_expenditures'] as $expenditure)
                                <tr>
                                    <td class="border px-4 py-2">{{ \Illuminate\Support\Carbon::parse($expenditure['transaction_date'])->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ \App\Services\Helpers\StringHelper::shortenAuto($expenditure['description']) }}</td>
                                    <td class="border px-4 py-2">{{ $expenditure['calculation_volume'] }} {{ $data['currency'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            const monthForm = document.getElementById('monthForm');
            const monthInput = monthForm.querySelector('#month');

            const date= new Date();
            const month=("0" + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            monthInput.value = `${year}-${month}`;

            monthInput.addEventListener('change', () => {
                monthForm.submit();
            });
        });
    </script>
</x-app-layout>
