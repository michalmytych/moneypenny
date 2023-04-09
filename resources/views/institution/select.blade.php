<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('institution.partials.single', ['institution' => $institution])

            <p class="my-4">
                Aby połączyć konto w instytucji finansowej z Moneypenny, musisz potwierdzić integrację na stronie internetowej instytucji.
                Czy chcesz przejść dalej?
            </p>

            @if($existingAgreement)
                <div class="mb-4">
                    @if(data_get($existingAgreement, 'is_successful'))
                        <div class="border-2 border-indigo-600 p-2 rounded text-indigo-500 font-semibold">
                            Już utworzyłeś zgodę w tej instytucji. Czy chcesz ją odświeżyć? Jeśli tak — przejdź dalej.
                        </div>
                    @else
                        <div class="border-2 border-red-700 p-2 rounded text-red-700 font-semibold">
                            Już próbowałeś utworzyć zgodę w tej instytucji, ale jest ona nieprawidłowa. Czy chcesz powtórzyć? Jeśli tak — przejdź dalej.
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex">
                <a href="{{ route('institution.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4">
                    Wróć
                </a>
                <form action="{{ route('institution.new_agreement', ['institutionId' => $institution->id]) }}" method="POST">
                    @csrf
                    <button type="submit" href="{{ route('institution.new_agreement', ['institutionId' => $institution->id]) }}"
                            class="border-2 border-indigo-500 text-indigo-500 hover:bg-indigo-600 hover:text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Przejdź dalej
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
