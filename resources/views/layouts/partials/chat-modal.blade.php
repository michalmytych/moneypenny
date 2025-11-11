@if(config('network.enabled') && request()->boolean('chat_opened'))
    <div id="chatModalBg" class="absolute z-10 right-0 top-0 px-8 w-full h-full"
         style="backdrop-filter: blur(8px); background-color: rgba(148,148,152,0.42);">
        <div class="flex justify-center pt-10 rounded-md bg-transparent">
            <div class="w-1/2">
                <div class="flex items-center">
                    <div class="text-3xl font-semibold mb-4 mt-20 flex items-center">
                        Social Chat
                        @include('components.maintenance.beta-badge')
                        <button id="closeButton" class="bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-500 text-md rounded-md" style="position: relative; left: 32vw;">
                            @include('icons.x')
                        </button>
                    </div>
                </div>
                @include('social.partials.chat-widget', ['chatMessages' => app(\App\Contracts\Infrastructure\Cache\CacheAdapterInterface::class)->get('chat_messages')])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const chatModal = document.getElementById('closeButton');
                chatModal.addEventListener('click', () => {
                    window.location.href = "{{ route(Route::current()->getName()) }}";
                });
            });
        </script>
    @endpush
@endif
