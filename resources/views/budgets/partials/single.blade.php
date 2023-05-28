<div class="bg-white rounded-md shadow-sm p-4 mb-4 transition">
    <div class="flex justify-between items-center">
        <h4 class="font-semibold flex text-2xl">
            <a href="{{ route('budget.edit', ['id' => $budget->id]) }}">
                <div class="relative -top-0.5 mr-2 text-indigo-600 cursor-pointer hover:text-indigo-400">
                    @include('icons.edit-xl')
                </div>
            </a>
            @if($budget->type === \App\Models\Transaction\Budget::TYPE_MONTH)
                Monthly
            @elseif($budget->type === \App\Models\Transaction\Budget::TYPE_WEEK)
                Weekly
            @elseif($budget->type === \App\Models\Transaction\Budget::TYPE_DAY)
                Daily
            @endif
            {{ $budget->name }}
        </h4>
        <h1 class="flex items-end">
            <span class="text-4xl font-semibold">{{ number_format($budget->amount, 2) }}</span>
            <span class="ml-1 text-xl">{{ $currencyCode }}</span>
        </h1>
    </div>
</div>
