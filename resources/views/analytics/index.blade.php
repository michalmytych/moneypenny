<x-app-layout>
    <div class="py-12 w-full mx-auto">
        <div class="w-full mx-auto sm:px-6 lg:px-8 pb-20">

            <h2 class="font-semibold text-4xl">
                {{ __('Total expenditures last month') }}
            </h2>

            <div class="mt-8 relative" style="max-height: 600px;">
                <div id="lastMonthExpendituresSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="lastMonthExpenditures" data-route="{{ route('api.analytic.index', ['chart_id' => 'lastMonthExpenditures']) }}"></canvas>
            </div>

            <h2 class="font-semibold text-4xl mt-20">
                {{ __('Expenditures trend last month') }}
            </h2>

            <div class="mt-12 relative" style="max-height: 600px;">
                <div id="expendituresAndIncomesTrendSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="expendituresAndIncomesTrend" data-route="{{ route('api.analytic.index', ['chart_id' => 'expendituresAndIncomesTrend']) }}"></canvas>
            </div>

            <h2 class="font-semibold text-4xl mt-20">
                {{ __('Categories percentage') }}
            </h2>

            <div class="mt-12 relative w-full" style="max-height: 600px;">
                <div id="categoriesPercentageSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="categoriesPercentage" data-route="{{ route('api.analytic.index', ['chart_id' => 'categoriesPercentage']) }}"></canvas>
            </div>

            <h2 class="font-semibold text-4xl mt-20">
                {{ __('Categorized vs uncategorized transactions') }}
            </h2>

            <div class="mt-12 relative pb-20 w-full" style="max-height: 600px;">
                <div id="categorizedPercentageSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="categorizedPercentage" data-route="{{ route('api.analytic.index', ['chart_id' => 'categorizedPercentage']) }}"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                window.drawCharts([
                    'categoriesPercentage',
                    'categorizedPercentage',
                    'lastMonthExpenditures',
                    'expendituresAndIncomesTrend'
                ]);
            });
        </script>
    @endpush

</x-app-layout>
