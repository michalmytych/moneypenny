<div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 p-2">
    <div class="flex justify-between">
        <div class="flex">
            <img src="{{ $institution->logo }}" alt="{{ $institution->name }} logo" style="width: 100px; height: 100px;"
                 class="ml-2 mt-2 mb-2 rounded-md">
            <ul class="ml-4">
                <li class="font-bold text-2xl">{{ $institution->name }}</li>
                <li class="font-italic">
                    Dodano {{ Carbon\Carbon::parse($agreement->nordigen_end_user_agreement_created)->format('d-m-Y h:i') }}</li>
                @if(count($agreement->requisitions) > 0)
                    <li class="font-semibold text-green-700">Requisitions have been filed</li>
                    <li>
                        @include('nordigen.synchronization.widget', ['agreement' => $agreement])
                    </li>
                @else
                    <li class="font-semibold text-indigo-600 hover:text-indigo-500">
                        <a href="{{ route('institution.agreements', ['id' => $institution->id]) }}">Make your first
                            requisition</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="h-20 flex justify-center items-start pt-3 pl-3 pr-6">
            <a href="{{ route('institution.agreements', ['id' => $institution->id]) }}"
               class="text-indigo-600 font-semibold pt-0.5 pr-8">
                Details
            </a>
            <div>
                <form action="{{ route('institution.delete_agreement', ['agreementId' => $agreement->id]) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hoverScaleBox">
                        @include('icons.trash')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
