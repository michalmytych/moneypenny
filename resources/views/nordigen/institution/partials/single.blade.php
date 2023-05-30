<div class="bg-white rounded-lg shadow-md overflow-hidden">

    <div class="flex">
        <img
            class="ml-2 mt-2 mb-2 rounded-md"
            style='height: 100px; width: 100px;'
            src="{{ $institution->logo }}" alt="{{ $institution->name }} logo">
        {{--<div--}}
        {{--      class="ml-2 mt-2 mb-2 rounded-md"--}}
        {{--      style='height: 100px; width: 100px; background-image: url("{{ $institution->logo }}"); background-size: cover;'--}}
        {{--></div>--}}
        <div class="p-4">
            <h2 class="text-lg font-bold">{{ $institution->name }}</h2>
            <p class="text-gray-500">{{ $institution->bic }}</p>
            <p class="text-gray-500">{{ $institution->transaction_total_days }} days of transactions available</p>
        </div>
    </div>

</div>
