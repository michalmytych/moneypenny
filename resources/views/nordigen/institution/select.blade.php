<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('nordigen.institution.partials.single', ['institution' => $institution])

            <p class="my-4">
                To connect your financial institution account to Moneypenny, you must confirm the integration on the institution's website.
                Do you want to move on?
            </p>

            @if($existingAgreement)
                <div class="mb-4">
                    @if(data_get($existingAgreement, 'is_successful'))
                        <div class="border-2 border-indigo-600 p-2 rounded text-indigo-500 font-semibold">
                            You have already created a consent with this institution. Do you want to refresh it? If so, move on.
                        </div>
                    @else
                        <div class="border-2 border-red-700 p-2 rounded text-red-700 font-semibold">
                            You have already tried to create a consent in this institution, but it is invalid. Do you want to repeat? If so, move on.
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex">
                <a href="{{ route('institution.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4">
                    Go back
                </a>
                <form action="{{ route('institution.new_agreement', ['institutionId' => $institution->id]) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="border-2 border-indigo-500 text-indigo-500 hover:bg-indigo-600 hover:text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Proceed with integration
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
