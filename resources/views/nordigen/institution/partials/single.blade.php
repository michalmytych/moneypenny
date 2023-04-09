<div class="bg-white rounded-lg shadow-md overflow-hidden">

    <div class="flex">
        <img src="{{ $institution->logo }}" alt="{{ $institution->name }} logo" height="20px" width="120px">
        <div class="p-4">
            <h2 class="text-lg font-bold">{{ $institution->name }}</h2>
            <p class="text-gray-500">{{ $institution->bic }}</p>
            <p class="text-gray-500">{{ $institution->transaction_total_days }} days of transactions available</p>
        </div>
    </div>

</div>
