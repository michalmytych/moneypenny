<div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
    <form method="POST" action="{{ route('transaction.create') }}">
        @csrf
        <h2 class="text-black font-bold text-2xl pb-4">Add new cash transaction</h2>

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

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                       for="transaction_date">
                    Transaction Date
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="transaction_date" name="transaction_date" type="date" placeholder="Enter Transaction Date"
                    required>
            </div>
            <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                       for="decimal_volume">
                    Decimal Volume
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="decimal_volume" name="decimal_volume" type="number" placeholder="Enter Decimal Volume" required>
            </div>
        </div>

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="description">
                    Description
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="description" name="description" type="text" placeholder="Enter Description" required>
            </div>
            <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="import_id">
                    Import ID
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="import_id" name="import_id" type="text" placeholder="Enter Import ID" required>
            </div>
        </div>

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="receiver">
                    Receiver
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="receiver" name="receiver" type="text" placeholder="Enter Receiver" required>
            </div>
            <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="currency">
                    Currency
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="currency" name="currency" type="text" placeholder="Enter Currency" required>
            </div>
        </div>

        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="sender">
                    Sender
                </label>
                <input
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                    id="sender" name="sender" type="text" placeholder="Enter Sender" required>
            </div>
            <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="type">
                    Type
                </label>
                <div class="relative">
                    <select
                        class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey"
                        id="type" name="type" required>
                        <option value="{{ \App\Models\Transaction\Transaction::TYPE_UNKNOWN }}">Unknown</option>
                        <option value="{{ \App\Models\Transaction\Transaction::TYPE_INCOME }}">Income</option>
                        <option value="{{ \App\Models\Transaction\Transaction::TYPE_EXPENDITURE }}">Expenditure</option>
                    </select>
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
