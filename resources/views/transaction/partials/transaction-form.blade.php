<div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
    <form method="POST" action="{{ route('transaction.create') }}">
        @csrf
        <h2 class="text-black font-bold text-2xl pb-4">Add new cash transaction</h2>

        @if(config('personas.enabled'))
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                           for="sender_persona_id">
                        Sender Persona
                    </label>
                    <select name="sender_persona_id" id="sender_persona_id"
                            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey">
                        <option>Select sender persona</option>
                        {{--@todo--}}
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->common_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                           for="receiver_persona_id">
                        Receiver Persona
                    </label>
                    <select name="receiver_persona_id" id="receiver_persona_id"
                            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey">
                        <option>Select receiver persona</option>
                        {{--@todo--}}
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->common_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <x-input-label for="transaction_date" :value="__('Transaction Date')" required/>
                <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full"
                              required autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('transaction_date')"/>
            </div>
            <div class="flex md:w-1/2">
                <div class="px-3 w-full">
                    <x-input-label for="decimal_volume" :value="__('Decimal volume')" required/>
                    <x-text-input id="decimal_volume" name="decimal_volume" type="number" class="mt-1 block w-full" required/>
                    <x-input-error class="mt-2" :messages="$errors->get('decimal_volume')"/>
                </div>
                <div class="px-3">
                    <x-input-label for="currency" :value="__('Currency')" required/>
                    <select id="currency" name="currency" placeholder="Enter Currency" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                        <option>Select currency</option>
                        @foreach(config('moneypenny.supported_currencies') as $currencyCode)
                            @if($currencyCode === config('moneypenny.base_calculation_currency'))
                                <option selected value="{{ $currencyCode }}">{{ $currencyCode }}</option>
                            @else
                                <option value="{{ $currencyCode }}">{{ $currencyCode }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('currency')" class="mt-2"/>
                </div>
            </div>
        </div>

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <x-input-label for="description" :value="__('Description')" required/>
                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required/>
                <x-input-error class="mt-2" :messages="$errors->get('description')"/>
            </div>
            <div class="md:w-1/2 px-3">
                <x-input-label for="receiver" :value="__('Receiver')"/>
                <x-text-input id="receiver" name="receiver" type="text" class="mt-1 block w-full"/>
                <x-input-error class="mt-2" :messages="$errors->get('receiver')"/>
            </div>
        </div>

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3">
                <x-input-label for="sender" :value="__('Sender')"/>
                <x-text-input id="sender" name="sender" type="text" class="mt-1 block w-full"/>
                <x-input-error class="mt-2" :messages="$errors->get('sender')"/>
            </div>

            <div class="md:w-1/2 px-3">
                <x-input-label for="type" :value="__('Type')" required/>
                <div class="relative">
                    <select
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full"
                        id="type" name="type" required>
                        <option value="{{ \App\Models\Transaction\Transaction::TYPE_INCOME }}">Income</option>
                        <option selected value="{{ \App\Models\Transaction\Transaction::TYPE_EXPENDITURE }}">
                            Expenditure
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end">
            <button
                class="bg-indigo-600 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"
                type="submit">
                Create Transaction
            </button>
        </div>
    </form>
</div>
