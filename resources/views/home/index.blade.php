<x-app-layout>
    <div class="pt-6 pb-8 w-full mx-auto">
        <div class="w-full mx-auto px-4 lg:px-8 pb-20">

            @include('home.partials.available-actions', ['transactionsData' => $transactionsData])

            <div id="headerSlider">
                @include('components.control.arrows-control', [
                    'leftId' => 'headerBackArrow',
                    'rightId' => 'headerNextArrow'
                ])
                <div id="mainHeader">
                    @include('home.partials.header', [
                        'saldoData' => $saldoData,
                        'budgetsWithConsumption' => $budgetsWithConsumption,
                        'eventNotifications' => $eventNotifications
                    ])
                </div>

                <div id="chartsHeader" style="position: absolute; left: -120vw;">
                    <div class="flex items-end justify-between">
                        <h2 class="text-2xl font-semibold">
                            {{ __('About your data') }}
                        </h2>

                        <a href="{{ route('analytic.index') }}" class="font-semibold text-indigo-600 hover:text-indigo-400 ml-2 flex items-center" style="margin-bottom: 1.5px;">
                            <span class="mr-2">{{ __('See more') }}</span>
                            @include('icons.go')
                        </a>
                    </div>


                    <div class="flex mb-4" style="min-height: 500px;">
                        <div class="mt-4 w-2/3 pl-2">
                            <div id="lastMonthExpendituresSkeleton"></div>
                            <canvas id="lastMonthExpenditures"
                                    data-route="{{ route('api.analytic.index', ['chart_id' => 'lastMonthExpenditures']) }}"></canvas>
                        </div>

                        <div class="mt-4 w-1/3">
                            <div id="categoriesPercentageSkeleton"></div>
                            <canvas id="categoriesPercentage"
                                    data-route="{{ route('api.analytic.index', ['chart_id' => 'categoriesPercentage']) }}"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            @include('home.partials.latest-transactions', ['transactionsData' => $transactionsData ])

        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const mainHeader = document.getElementById('mainHeader');
                const chartsHeader = document.getElementById('chartsHeader');
                const headerBackArrow = document.getElementById('headerBackArrow');
                const headerNextArrow = document.getElementById('headerNextArrow');

                const chartsToRender = [
                    'categoriesPercentage',
                    'lastMonthExpenditures'
                ];

                headerNextArrow.addEventListener('click', () => {
                    mainHeader.style.position = 'absolute';
                    mainHeader.style.left = '-120vw';

                    chartsHeader.style.left = '0';
                    chartsHeader.style.position = 'static';

                    mainHeader.classList.remove('fade-in');
                    chartsHeader.classList.add('fade-in');

                    window.drawCharts(chartsToRender);
                });

                headerBackArrow.addEventListener('click', () => {
                    mainHeader.style.left = '0';
                    mainHeader.style.position = 'static';

                    chartsHeader.style.position = 'absolute';
                    chartsHeader.style.left = '-120vw';

                    chartsHeader.classList.remove('fade-in');
                    mainHeader.classList.add('fade-in');
                });
            });
        </script>
    @endpush
</x-app-layout>
