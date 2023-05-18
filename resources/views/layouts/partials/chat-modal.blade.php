@if(config('chat.enabled') && request()->boolean('chat_opened'))
    <div id="chatModal" class="absolute z-10 right-0 top-0 px-8 w-full h-full" style="backdrop-filter: blur(6px); background-color: rgba(148,148,152,0.42);">
        <div class="flex justify-center pt-10 rounded-md bg-transparent">
            <div class="w-1/2">
                <div class="flex items-center">
                    <h2 class="text-3xl font-semibold mb-4">Social Chat</h2>
                    @include('components.mainteance.beta-badge')
                </div>
                @include('social.partials.chat-widget', ['chatMessages' => \Illuminate\Support\Facades\Cache::get('chat_messages')])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const chatModal = document.getElementById('chatModal');
                chatModal.addEventListener('click', () => {
                    window.location.href = "{{ route(Route::current()->getName()) }}";
                });
            });
        </script>
    @endpush
@endif
