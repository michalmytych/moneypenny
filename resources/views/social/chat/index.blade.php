<x-app-layout>
    <div class="pt-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div>
                <div class="flex items-center">
                    <h2 class="text-3xl font-semibold mb-4">Social Chat</h2>
                    @include('components.mainteance.beta-badge')
                </div>
                @if(config('network.enabled'))
                    @include('social.partials.chat-widget')
                @else
                    <h2 class="text-xl">Feature is unavailable.</h2>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
