@php
    /** @var array $transactionsData */
    $transactions = $transactionsData['transactions'];
    $synchronization = $transactionsData['last_synchronization'];
    $agreement = $transactionsData['agreement'];
    $count = $transactionsData['count'];
@endphp

<div class="mt-2 bg-gray-100 rounded-lg w-full mb-4 flex items-center">
    <h2 class="text-xl mr-4" style="font-weight: 600;">{{ __('Latest transactions') }}</h2>
    @php
        $timePassed = null;
        if ($synchronization) {
             $timePassed = \App\Services\Helpers\TimeHelper::ax_getRoughTimeElapsedAsText(
                $synchronization->created_at->timestamp
            );
        }
    @endphp
    <div class="flex items-center mb-1">
        @include('nordigen.synchronization.widget', ['agreement' => $agreement, 'reload' => true])
        <h2 class="ml-2 text-gray-500 font-light relative top-0.5"> {{ $timePassed ? 'Last synchronization ' . $timePassed . ' ago' : 'No synchronizations' }}</h2>
        <!-- @todo fix style -->
        <!-- <div class="text-gray-500 bg-green-500">Transaction in total: {{ $count ?? 0 }}</div> -->
    </div>
</div>

@include('transaction.partials.transactions-list', ['transactions' => $transactions])

