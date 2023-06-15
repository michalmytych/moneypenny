<x-app-layout>
    <div class="w-full mx-auto">
        <div class="w-full mx-auto">
            <div class="mt-6 w-screen fixed left-0" style="max-height: 600px;">
                <div class="w-full mb-2 rounded-xl" style="height: 600px;">
                    <div class="w-full flex h-4/5 sm:h-full items-center justify-center overflow-hidden">
                        <div>
                            @include('icons.loader')
                            <h2 class="mt-2 text-gray-700 text-2xl font-semibold">Setting up your account</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const redirectUrl = "{{ $redirect }}";
                const currentApiToken = "{{ $currentApiToken }}";

                setTimeout(() => {
                    window.localStorage.setItem('SANCTUM_API_TOKEN', currentApiToken);
                    window.location.href = redirectUrl;
                }, 2500);
            });
        </script>
    @endpush
</x-app-layout>
