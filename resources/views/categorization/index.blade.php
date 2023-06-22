<x-app-layout>
    <section class="mt-12 mx-4">
        <div class="flex items-center justify-between">
            <h2 class="text-black font-bold text-3xl pt-7">{{ __('Transactions categorization') }}</h2>

            <form method="POST" action="{{ route('categorization.trigger') }}" class="mt-6 space-y-6">
                @csrf

                @if($recategorizationsIsRunning)
                    <div class="flex items-center justify-end gap-4">
                        <x-secondary-button disabled="true">
                        <span class="flex items-center">
                            <span class="mr-2">@include('icons.loader-sm')</span>
                            <span class="mt-1">{{ __('Running categorization...') }}</span>
                        </span>
                        </x-secondary-button>
                    </div>
                @else
                    <div class="flex items-center justify-end gap-4">
                        <x-primary-button>
                        <span class="flex items-center">
                            <span class="mr-2">@include('icons.sm.sync')</span>
                            <span class="mt-1">{{ __('Recategorize') }}</span>
                        </span>
                        </x-primary-button>
                    </div>
                @endif
            </form>
        </div>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Here you can view categorization stats and manually trigger recategorization.") }}
        </p>

        <div class="mt-2 flex items-end">
            <h2 class="font-bold text-2xl">{{ number_format((float)$stats['categorized_percent'] * 100, 2) }}%</h2>
            <span class="ml-2 text-sm text-gray-600 pb-0.5"> {{ __('of transactions is categorized.') }}</span>
        </div>

        <div class="w-full flex">
            <div class="mt-12 relative w-1/2" style="max-height: 450px;">
                <div id="categoriesPercentageSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="categoriesPercentage" data-route="{{ route('api.analytic.index', ['chart_id' => 'categoriesPercentage']) }}"></canvas>
            </div>

            <div class="mt-12 relative pb-20 w-1/2" style="max-height: 530px;">
                <div id="categorizedPercentageSkeleton" class="bg-gray-50 h-3/4 w-full mb-2 rounded-xl" style="height: 600px; position: absolute;">
                    <div class="w-full flex h-full items-center justify-center">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Loading data</h2>
                        </div>
                    </div>
                </div>
                <canvas id="categorizedPercentage" data-route="{{ route('api.analytic.index', ['chart_id' => 'categorizedPercentage']) }}"></canvas>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-black font-bold text-3xl pt-7">{{ __('Uncategorized transactions') }}</h2>
            <div class="mt-6 pb-24">
                @include('transaction.partials.transactions-list', ['transactions' => $uncategorizedTransactions])
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                window.drawCharts([
                    'categoriesPercentage',
                    'categorizedPercentage'
                ]);
            });
        </script>
    @endpush

    @push('scripts')
        <script>
            window.addEventListener('load', function () {
                const notifPreviewBtn = document.getElementById('notifPreviewBtn');

                notifPreviewBtn.addEventListener('click', () => {
                    notifPreviewBtn.disabled = true;
                    window.setTimeout(() => {
                        notifPreviewBtn.disabled = false;
                    }, 6000);

                    const urlInput = document.getElementById('urlInput');
                    const headerInput = document.getElementById('headerInput');
                    const contentInput = document.getElementById('contentInput');

                    showNotification({
                        header: headerInput.value,
                        message: contentInput.value,
                        url: urlInput.value,
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
