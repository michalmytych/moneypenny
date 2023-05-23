@if(count($synchronizations) > 0)
    <div class="p-4">
        <h2 class="text-3xl font-semibold mb-4">{{ __('Synchronizations') }}</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created at') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($synchronizations as $sync)
                <tr>
                    <td class="pl-6 py-2">{{ $sync->created_at->format('d.m.Y H:i') }}</td>
                    <td class="pl-6 py-2">
                        @if($sync->status == \App\Models\Synchronization\Synchronization::SYNC_STATUS_RUNNING)
                            <span class="text-blue-600 font-semibold">
                                {{ __('Running') }}
                            </span>
                        @elseif($sync->status == \App\Models\Synchronization\Synchronization::SYNC_STATUS_FAILED)
                            <span class="text-red-500 font-semibold">
                                {{ __('Failed') }}
                            </span>
                        @elseif($sync->status == \App\Models\Synchronization\Synchronization::SYNC_STATUS_SUCCEEDED)
                            <span class="text-green-600 font-semibold">
                                {{ __('Succeeded') }}
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">
        {{ __('No synchronizations') }}
    </h2>
@endif
