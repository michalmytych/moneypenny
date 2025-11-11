<div>
    <form action="{{ route('transaction.toggle_exclude_from_calculation', ['id' => $transaction->id]) }}" method="POST">
        @csrf
        @if($transaction->is_excluded_from_calculation)
            <div class="mb-2">
                Currently transaction is <span class="font-bold">not included</span> in calculations.
            </div>
            <button
                class="text-indigo-600 hover:text-indigo-400 font-bold rounded-lg focus:outline-none focus:shadow-outline flex items-center"
                type="submit">
                <div class="w-6 h-6 mt-0.5">
                    @include('icons.edit')
                </div>
                Include in calculations
            </button>
        @else
            <div class="mb-2">
                Currently transaction is included in calculations.
            </div>
            <button
                class="text-red-600 hover:text-red-400 font-bold rounded-lg focus:outline-none focus:shadow-outline flex items-center"
                type="submit">
                <div class="w-6 h-6 mt-0.5">
                    @include('icons.edit')
                </div>
                Exclude from calculations
            </button>
        @endif
    </form>
</div>
