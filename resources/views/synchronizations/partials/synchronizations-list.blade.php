@if(count($imports) > 0)
    <div class="bg-white shadow-md rounded my-6">
        <div class="flex justify-between items-center bg-gray-200 py-3 px-4 rounded-t">
            <h2 class="font-bold text-lg">Synchronization List</h2>
            <a href="#" class="text-indigo-500 hover:text-indigo-700">View All</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-gray-700">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($synchronizations as $sync)
                    <tr class="hover:bg-gray-100">
                        <td class="border-t">
                            <div class="px-4 py-3">{{ $sync->id }}</div>
                        </td>
                        <td class="border-t">
                            <div class="px-4 py-3">
                                @if($sync->status == \App\Models\Synchronization::SYNC_STATUS_RUNNING)
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-500 text-white rounded-full">
                                Running
                            </span>
                                @elseif($sync->status == \App\Models\Synchronization::SYNC_STATUS_FAILED)
                                    <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white rounded-full">
                                Failed
                            </span>
                                @elseif($sync->status == \App\Models\Synchronization::SYNC_STATUS_SUCCEEDED)
                                    <span class="inline-flex items-center px-2 py-1 bg-green-500 text-white rounded-full">
                                Succeeded
                            </span>
                                @endif
                            </div>
                        </td>
                        <td class="border-t">
                            <div class="px-4 py-3">
                                <a href="#" class="text-indigo-500 hover:text-indigo-700">View Details</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@else
    <h2 class="font-semibold text-xl">Brak synchronizacji</h2>
@endif
