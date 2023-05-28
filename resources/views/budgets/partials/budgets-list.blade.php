@if(count($budgets) > 0)
    @php
        $budgetsWithConsumption = $budgets;
    @endphp
    <h2 class="text-black font-bold text-2xl pb-4 pt-4">{{ __('Your budgets') }}</h2>
    <div>
        @foreach($budgetsWithConsumption as $budgetWithConsumption)
            <a href="{{ route('budget.show', ['id' => $budgetWithConsumption['budget']->id]) }}">
                <div class="bg-white rounded-md shadow-sm p-4 mb-4 transition scale-hover">
                    <div class="flex justify-between items-center">
                        <h4 class="text-indigo-500 font-bold text-xl">
                            @if($budgetWithConsumption['budget']->type === \App\Models\Transaction\Budget::TYPE_MONTH)
                                Monthly
                            @elseif($budgetWithConsumption['budget']->type === \App\Models\Transaction\Budget::TYPE_WEEK)
                                Weekly
                            @elseif($budgetWithConsumption['budget']->type === \App\Models\Transaction\Budget::TYPE_DAY)
                                Daily
                            @endif
                            {{ $budgetWithConsumption['budget']->name }}
                        </h4>
                        <h1 class="flex items-end">
                            <div>
                                <span class="font-semibold text-xl">
                                    {{ number_format($budgetWithConsumption['period_expenditures_sum'], 2) }}
                                    <span class="font-semibold text-3x">/</span>
                                </span>
                                <span
                                    class="text-4xl font-semibold">{{ number_format($budgetWithConsumption['budget']->amount, 2) }}</span>
                                <span class="ml-1 text-xl">{{ $currencyCode }}</span>
                                <span class="font-semibold text-2xl ml-4">
                                    @php
                                        $consumptionPercentage = (float) $budgetWithConsumption['consumption'] * 100;
                                    @endphp
                                    @if($consumptionPercentage > 100)
                                        <span class="text-red-800">
                                            {{ number_format($consumptionPercentage) }}% used
                                        </span>
                                    @else
                                        <span>
                                            {{ number_format($consumptionPercentage) }}% used
                                        </span>
                                    @endif

                                </span>
                            </div>
                        </h1>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No budgets') }}</h2>
@endif


