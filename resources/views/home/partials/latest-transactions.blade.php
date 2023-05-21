@php
    /** @var array $transactionsData */
    $transactions = $transactionsData['transactions'];
    $synchronization = $transactionsData['last_synchronization'];
    $agreement = $transactionsData['agreement'];
@endphp

<div class="my-6 bg-gray-100 rounded-lg w-full">
    @php
        $timePassed = null;
        if ($synchronization) {
             $timePassed = \App\Services\Helpers\TimeHelper::ax_getRoughTimeElapsedAsText(
                $synchronization->created_at->timestamp
            );
        }
    @endphp
    <div class="flex items-center">
        @include('nordigen.synchronization.widget', ['agreement' => $agreement, 'reload' => true])
        <h2 class="ml-2 text-gray-500 font-light relative top-0.5"> {{ $timePassed ? 'Last synchronization ' . $timePassed . ' ago' : 'No synchronizations' }}</h2>

    </div>
</div>

@include('transaction.partials.transactions-list', ['transactions' => $transactions])

