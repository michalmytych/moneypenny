@if(count($users) > 0)
    <h2 class="text-black font-bold text-3xl pb-4 pt-4">{{ __('Users') }}</h2>
    <div>
        @foreach($users as $user)
            <div class="bg-white rounded-md shadow-sm p-4 mb-4 transition flex">
                <div class="w-3/5 mt-1">
                    <div class="flex justify-between items-start">
                            <div class="text-xl font-semibold flex">
                                <span>{{ $user->name }}</span>
                                <div class="relative top-1 flex justify-between">
                                    <div class="mr-2 ml-2">
                                        @if($user->isAdmin())
                                            @include('admin.partials.admin-badge')
                                        @endif
                                    </div>
                                    @if($user->isBlocked())
                                        @include('admin.partials.blocked-badge')
                                    @endif
                                </div>
                            </div>
                            <span class="text-gray-500">
                                {{ $user->email }}
                            </span>
                            <div class="font-light text-gray-500">{{ __('Joined') }}: {{ $user->created_at }}</div>
                    </div>
                </div>
                <div class="w-2/5 flex mt-1 justify-end">
                    <a href="{{ route('user.show', ['id' => $user->id]) }}">
                        <div class="font-semibold text-indigo-600">Details</div>
                    </a>
                    <div class="h-6 bg-gray-300 mx-4" style="width: 1.5px;"></div>
                    <a href="{{ route('user.confirm_change_role', ['id' => $user->id]) }}">
                        <div class="font-semibold text-indigo-600">Change role</div>
                    </a>
                    <div class="h-6 bg-gray-300 mx-4" style="width: 1.5px;"></div>
                    <a href="{{ route('user.confirm_block', ['id' => $user->id]) }}">
                        @if($user->isBlocked())
                            <div class="font-semibold text-indigo-600">Unblock</div>
                        @else
                            <div class="font-semibold text-indigo-600 mr-2">Block</div>
                        @endif
                    </a>
                    <div class="h-6 bg-gray-300 mx-4" style="width: 1.5px;"></div>
                    <a href="{{ route('user.confirm_delete', ['id' => $user->id]) }}">
                        <div class="font-semibold mr-2 text-red-600">Delete</div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No other users') }}</h2>
@endif

