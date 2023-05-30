<x-app-layout>
    <div class="pt-6 pb-8 w-full mx-auto">
        <div class="w-full mx-auto px-4 lg:px-8 pb-20 mt-6">

            <div class="mb-6 w-full">
                <h2 class="text-lg font-semibold mb-2">{{ __('Edit account balance') }}</h2>
                <form action="{{ route('personal-account.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex w-full items-end">
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            id="value"
                            name="value"
                            class="appearance-none border text-7xl text-semibold rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            style="width: fit-content;"
                            value="{{ $personalAccount?->value ?? 0.0 }}"
                        >
                        <x-input-error :messages="$errors->get('value')" class="mt-2"/>
                        <span class="text-xl ml-3 mr-3">PLN</span>
                        <div class="flex items-end">
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg"
                                    id="uploadButton">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
