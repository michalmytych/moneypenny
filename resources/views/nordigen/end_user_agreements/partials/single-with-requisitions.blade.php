<div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
    <div class="flex">
        <img src="{{ $institution->logo }}" alt="{{ $institution->name }} logo" height="20px" width="120px">
        <ul class="ml-4">
            <li class="font-bold text-2xl">{{ $institution->name }}</li>
            <li class="font-italic">Dodano {{ Carbon\Carbon::parse($agreement->nordigen_end_user_agreement_created)->format('d-m-Y h:i') }}</li>
        </ul>
    </div>
    <div>
        @if(count($agreement->requisitions) > 0)
            <h2 class="font-semibold text-2xl my-4 ml-4">Złożone rekwizycje</h2>
            @foreach($agreement->requisitions as $requisition)
                @include('nordigen.requisitions.partials.single', ['requisition' => $requisition])
            @endforeach
        @else
            <div class="p-4">
                <div class="my-4 text-2xl font-semibold">
                    Nie złożono jeszcze rekwizycji
                </div>
                <div class="font-semibold text-indigo-600 hover:text-indigo-500">
                    <form action="{{ route('institution.new_requisition', ['agreementId' => $agreement->id]) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="border-2 border-indigo-500 text-indigo-500 hover:bg-indigo-600 hover:text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Złóż rekwizycję
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
