<div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
    <div class="flex">
        <img src="{{ $institution->logo }}" alt="{{ $institution->name }} logo" height="20px" width="120px">
        <ul class="ml-4">
            <li class="font-bold text-2xl">{{ $institution->name }}</li>
            <li class="font-italic">Dodano {{ Carbon\Carbon::parse($agreement->nordigen_end_user_agreement_created)->format('d-m-Y h:i') }}</li>
            @if(count($agreement->requisitions) > 0)
                <li class="font-semibold text-green-700">Złożono rekwizycje</li>
            @else
                <li class="font-semibold text-indigo-600 hover:text-indigo-500">
                    <a href="{{ route('institution.agreements', ['id' => $institution->id]) }}">Złóż pierwszą rekwizycję</a>
                </li>
            @endif
        </ul>
    </div>
</div>
