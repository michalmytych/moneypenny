@if(count($users) > 0)
    <h2 class="text-black font-bold text-2xl pb-4 pt-4">{{ __('Users') }}</h2>
    <div>
        @foreach($users as $user)
            <div class="bg-white rounded-md shadow-sm p-4 mb-4 transition flex">
                <div class="w-1/2">
                    <div class="flex justify-between items-center">
                        <h4>
                            <div class="text-xl font-semibold flex mb-2">
                                <span>{{ $user->name }}</span>
                                <div class="relative top-1">
                                    @if($user->isAdmin())
                                        @include('admin.partials.admin-badge')
                                    @endif
                                </div>
                            </div>
                            <span class="text-gray-500">
                                {{ $user->email }}
                            </span>
                        </h4>
                    </div>
                    <div class="font-light text-gray-500 my-2">{{ __('Joined') }}: {{ $user->created_at }}</div>
                </div>
                <div class="w-1/2 flex justify-end">
                    <a href="{{ route('user.confirm_change_role', ['id' => $user->id]) }}">
                        <div class="font-semibold text-indigo-600">Change role</div>
                    </a>
                    <div class="h-6 bg-gray-300 mx-4" style="width: 1.5px;"></div>
                    <a href="{{ route('user.confirm_block', ['id' => $user->id]) }}">
                        <div class="font-semibold text-indigo-600">Block</div>
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

