<div class="mt-6 pb-24">
    <h1 class="text-4xl font-bold mb-4">
        {{ __('Transactions categories') }}
    </h1>
    @if(count($categories) > 0)
        <div>
            @foreach($categories as $category)
                <div class="bg-white rounded-md shadow-sm p-4 mb-4 transition">
                    <div class="flex justify-between items-center">
                        <h4 class="text-xl font-semibold flex">
                            {{ \Illuminate\Support\Str::ucfirst($category->code) }}
                        </h4>
                    </div>
                    <div class="font-light text-gray-500 mt-2">{{ $category->transactions_count }} transactions</div>
                </div>
            @endforeach
        </div>
    @else
        <h2 class="font-semibold text-xl">{{ __('No categories') }}</h2>
    @endif
</div>
