<div class="bg-white rounded-md shadow-sm p-4 mb-4 transition">
    <form action="{{ route('budget.create') }}" method="POST">
        @csrf
        <a href="{{ route('budget.index') }}">
            <div class="relative -top-0.5 mr-2 text-indigo-600 cursor-pointer hover:text-indigo-400 font-semibold">
                {{ __('Go back') }}
            </div>
        </a>
        <div class="flex items-center mt-2">
            <div class="font-semibold flex text-2xl items-end w-full">
                <select name="type" id="type"
                        class="text-2xl appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @php
                        $types = [
                            ['name' => 'Monthly', 'value' => \App\Models\Transaction\Budget::TYPE_MONTH, 'selected' => isset($budget) && $budget->type === \App\Models\Transaction\Budget::TYPE_MONTH],
                            ['name' => 'Weekly', 'value' => \App\Models\Transaction\Budget::TYPE_WEEK, 'selected' => isset($budget) && \App\Models\Transaction\Budget::TYPE_WEEK],
                            ['name' => 'Daily', 'value' => \App\Models\Transaction\Budget::TYPE_DAY, 'selected' => isset($budget) && \App\Models\Transaction\Budget::TYPE_DAY],
                        ];
                    @endphp
                    @foreach($types as $type)
                        <option
                            @if($type['selected'])
                                selected
                            @endif
                            value="{{ $type['value'] }}">{{ $type['name'] }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="{{ __('Budget name') }}"
                    value="{{ isset($budget) ? $budget->name : '' }}"
                    class="text-2xl ml-4 w-1/2 appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                <input
                    type="number"
                    step="0.01"
                    name="amount"
                    id="name"
                    value="{{ isset($budget) ? $budget->amount : 0 }}"
                    class="text-2xl ml-4 w-1/3 appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <x-input-error :messages="$errors->get('amount')" class="mt-2"/>
                <span class="ml-1 text-xl">{{ $currencyCode }}</span>
            </div>
        </div>
        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>
