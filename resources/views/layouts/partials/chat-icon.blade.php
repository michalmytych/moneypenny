<div class="w-14 mr-0.5">
    <button
        class="inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
        <div class="mr-7 font-bold">
            <a href="{{  route(Route::current()->getName()) . '?chat_opened=true' }}">
                @include('icons.chat')
            </a>
        </div>
    </button>
</div>
