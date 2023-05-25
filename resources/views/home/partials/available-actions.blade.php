<div class="mb-6">
    @if(count(data_get($transactionsData, 'transactions')) === 0)
        <div class="mb-4">
            <a href="{{ route('institution.index') }}">
                <div
                    class="rounded-md transition shadow text-white lg:flex items-center pr-6 p-2 cursor-pointer hover:scale-[1.01] active:scale-[0.99] bg-gradient-to-r from-indigo-700 via-indigo-500 to-indigo-400 flex">
                    @include('icons.add')
                    <div>
                        <div class="flex items-center">
                        <span class="font-semibold text-2xl ml-2">
                            Add source of financial data.
                        </span>
                        </div>

                        <span class="ml-2 relative top-0.5">
                            Transactions database is currently empty.
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endif

    @if($endUserAgreementCount > 0 && $synchronizationsCount === 0)
        <div class="mb-4">
            <a href="{{ route('institution.index') }}">
                <div
                    class="rounded-md transition shadow text-white flex items-center pr-6 p-2 cursor-pointer hover:scale-[1.01] active:scale-[0.99] bg-gradient-to-r from-emerald-500 via-green-600 to-indigo-400 flex">

                    @include('icons.check-circle')
                    <div>
                        <div class="flex items-center">
                    <span class="font-semibold text-2xl ml-2">
                        New integration added.
                    </span>
                        </div>

                        <span class="ml-2 relative top-0.5">
                    Now let's synchronize transactions
                </span>
                    </div>

                </div>
            </a>
        </div>
    @endif

    @if(request()?->user()->created_at->gte(now()->subMinutes(10)))
        <div class="mb-8">
            <a href="{{ route('report.periodic') }}">
                <div
                    class="rounded-md transition shadow text-white flex items-center pr-6 p-2 cursor-pointer hover:scale-[1.01] active:scale-[0.99] bg-gradient-to-r from-emerald-500 via-green-600 to-indigo-400">

                    @include('icons.arrow-trending')
                    <div>
                        <div class="flex items-center">
                        <span class="font-semibold text-2xl ml-2">
                            First report is waiting for you.
                        </span>
                        </div>

                        <span class="ml-2 relative top-0.5">
                        Show first report
                    </span>
                    </div>
                </div>
            </a>
        </div>
    @endif
</div>
