<div class="lg:grid lg:grid-cols-3">
    <div class="col-1 mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ __('Account balance') }}</h2>
        <div class="flex">
            <a href="{{ route('personal-account.edit') }}"
               class="bg-transparent hover:bg-gray-200 w-full p-2 mr-2 transition rounded-md flex">
                <h1 id="saldoDisplay" class="text-5xl text-semibold" style="font-weight: 500;">{{ $saldoData }}</h1>
                <span class="text-xl ml-2">PLN</span>
                {{--@todo - resolve currency--}}
            </a>
        </div>
        <div class="grid grid-cols-2 mt-6">
            <div class="hover:bg-gray-200 p-2 rounded-md mr-2 cursor-pointer">
                <h3 class="text-sm font-semibold">{{ __('Expenditures today') }}</h3>
                <div class="flex">
                    <h4 class="text-2xl text-semibold" style="font-weight: 600; opacity: 0;" id="expendituresTodayTotal"></h4>
                    <span class="ml-2 text-sm">PLN</span>
                </div>

            </div>
            <div class="hover:bg-gray-200 p-2 rounded-md mr-2 cursor-pointer">
                <h3 class="text-sm font-semibold">{{ __('Incomes today') }}</h3>
                <div class="flex">
                    <h4 class="text-2xl text-semibold" style="font-weight: 600; opacity: 0;" id="incomesTodayTotal"></h4>
                    <span class="ml-2 text-sm">PLN</span>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-2 mt-4">
            <div class="hover:bg-gray-200 p-2 rounded-md mr-2 cursor-pointer">
                <h3 class="text-sm font-semibold">{{ __('Expenditures this week') }}</h3>
                <div class="flex">
                    <h4 class="text-2xl text-semibold" style="font-weight: 600; opacity: 0;" id="expendituresThisWeekTotal"></h4>
                    <span class="ml-2 text-sm">PLN</span>
                </div>

            </div>
            <div class="hover:bg-gray-200 p-2 rounded-md mr-2 cursor-pointer">
                <h3 class="text-sm font-semibold">{{ __('Incomes this week') }}</h3>
                <div class="flex">
                    <h4 class="text-2xl text-semibold" style="font-weight: 600; opacity: 0;" id="incomesThisWeekTotal"></h4>
                    <span class="ml-2 text-sm">PLN</span>
                </div>

            </div>
        </div>
    </div>

    <div class="mb-10 pr-6">
        <h2 class="text-xl font-semibold mb-2">{{ __("Events") }}</h2>
        @foreach($eventNotifications as $eventNotification)
            @php
                $notificationContent = json_decode(data_get($eventNotification, 'content'));
                $eventHeader = data_get($notificationContent, 'header');
                $rawEventContent = data_get($notificationContent, 'content');
                $eventContent = \App\Services\Helpers\StringHelper::shortenAuto($rawEventContent, 30);
                $eventUrl = data_get($notificationContent, 'url');
            @endphp
            <a href="{{ $eventUrl ?? route('home') }}">
                <div
                    class="py-2 pr-1 rounded-md w-full bg-gray-200 mb-4 flex items-center pl-3 hover:scale-105 cursor-pointer transform-gpu transition duration-150 ease-out hover:ease-in shadow-sm hover:shadow-md">
                    @include('icons.report')
                    <span class="text-black-50 text-xs ml-3">
                    <span class="font-bold">{{ $eventHeader }}</span>
                    <div>{{ $eventContent }}</div>
                </span>
                </div>
            </a>
        @endforeach
        @if(count($eventNotifications) === 0)
            <h3 class="text-gray-600 font-light">Nothing new</h3>
        @endif
    </div>

    <div class="lg:ml-6">
        <a href="{{ route('budget.index') }}">
            <h2 class="text-xl font-semibold">{{ __("Budgets consumption") }}</h2>
            <ul id="fadeInList" class="list-none sm:md:my-2">
                @foreach($budgetsWithConsumption as $budgetData)
                    @php
                        $budget = $budgetData['budget'];
                        $consumptionPercentage = $budgetData['consumption'] * 100;
                        if ($consumptionPercentage > 100) {
                            $consumptionPercentage = 100;
                        }
                    @endphp
                    <div class="mb-2 mt-6 w-full">
                        <div
                            class="text-sm w-full text-left mr-4 mb-2 font-semibold @if($consumptionPercentage === 100) text-red-800 @else text-gray-700 @endif">
                            @if($budget->type === \App\Models\Transaction\Budget::TYPE_MONTH)
                                Monthly
                            @elseif($budget->type === \App\Models\Transaction\Budget::TYPE_WEEK)
                                Weekly
                            @elseif($budget->type === \App\Models\Transaction\Budget::TYPE_DAY)
                                Daily
                            @endif
                            <span class="text-sm">
                                {{ $budget->name }}
                            </span>
                            <span class="ml-2 font-light">
                                {{ number_format($consumptionPercentage, 2) }}%
                            </span>
                        </div>
                        <li class="bg-gray-200 rounded-md w-full shadow mr-4 mb-7" style="height: 16px;">
                            <div
                                id="budgetConsumption{{ $budget->id }}"
                                data-percentage="{{ $consumptionPercentage }}"
                                class="bg-indigo-600 rounded-md mb-4" style="height: 16px;">
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
        </a>
    </div>
</div>

@push('scripts')
    <script>
        function animateToValue(elementId, targetValue) {
            const element = document.getElementById(elementId);
            let value = 0;
            const targetIntValue = targetValue * 100;
            const duration = 800;

            function animate(timestamp) {
                const progress = Math.min(1, (timestamp - startTime) / duration);
                value = Math.floor(progress * targetIntValue);
                element.innerHTML = (value / 100).toFixed(2);
                element.style.opacity = progress;

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            let startTime = performance.now();
            element.style.opacity = 0;
            requestAnimationFrame(function (timestamp) {
                startTime = timestamp;
                element.style.display = 'block';
                requestAnimationFrame(animate);
            });
        }

        function animateLoader(elementNode, targetValue) {
            if (targetValue > 100) {
                targetValue = 100;
            }

            const loaderWidth = 100;
            const duration = 800;

            const targetWidth = (targetValue / 100) * loaderWidth;

            function animate(timestamp) {
                const progress = Math.min(1, (timestamp - startTime) / duration);
                const width = progress * targetWidth;
                elementNode.style.width = width + '%';

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            let startTime = performance.now();
            elementNode.style.width = '0';
            requestAnimationFrame(function (timestamp) {
                startTime = timestamp;
                elementNode.style.display = 'block';
                requestAnimationFrame(animate);
            });
        }

        window.addEventListener('load', () => {
            let saldoValue = 0.00;
            try {
                saldoValue = parseFloat(document.getElementById('saldoDisplay').innerText);
            } catch (e) {
                //
            }

            animateToValue('saldoDisplay', saldoValue);
            animateToValue('expendituresTodayTotal', {{ $expendituresTodayTotal ?? 0 }});
            animateToValue('incomesTodayTotal', {{ $incomesTodayTotal ?? 0 }});
            animateToValue('expendituresThisWeekTotal', {{ $expendituresThisWeekTotal ?? 0 }});
            animateToValue('incomesThisWeekTotal', {{ $incomesThisWeekTotal ?? 0 }});

            document
                .querySelectorAll("[id^='budgetConsumption']")
                .forEach(element => {
                    const value = element.dataset.percentage;
                    console.log(value)
                    animateLoader(element, parseInt(value));
                });
        });
    </script>
@endpush
