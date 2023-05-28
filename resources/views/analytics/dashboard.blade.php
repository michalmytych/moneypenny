<x-app-layout>
    <div class="py-16 w-full mx-auto">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="mt-12 relative" style="max-height: 600px;">
                <div id="lastMonthExpendituresSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="lastMonthExpenditures" data-route="{{ route('apitest', ['chart_id' => 'lastMonthExpenditures']) }}"></canvas>
            </div>

            <div class="mt-12 relative" style="max-height: 600px;">
                <div id="expendituresAndIncomesTrendSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="expendituresAndIncomesTrend" data-route="{{ route('apitest', ['chart_id' => 'expendituresAndIncomesTrend']) }}"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                window.drawCharts([
                    'lastMonthExpenditures',
                    'expendituresAndIncomesTrend'
                ]);
            });
        </script>
    @endpush

</x-app-layout>
