<div class="px-8 pb-8 mb-4 flex flex-col">
    <h1 class="text-3xl font-bold mb-4">{{ __('Settings') }}</h1>
    <form action="{{ route('setting.update') }}" method="POST">
        @csrf
        <div class="my-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="currency">
                Base calculation currency
            </label>
            <div class="text-gray-600 mt-3 mb-4">
                All calculations performed on transactions will be performed with this currency.
            </div>
            <select id="base_currency_code" name="base_currency_code" placeholder="Select currency" required
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey">
                <option>Select currency</option>
                @foreach(config('moneypenny.supported_currencies') as $currencyCode)
                    @if($currencyCode === $settings?->base_currency_code || $currencyCode === config('moneypenny.base_calculation_currency'))
                        <option selected value="{{ $currencyCode }}">{{ $currencyCode }}</option>
                    @else
                        <option value="{{ $currencyCode }}">{{ $currencyCode }}</option>
                    @endif
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('base_currency_code')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>

