<div id="applicationNotification" class="fixed z-50 flex justify-center w-full transition-all hover:translate-x-1.5" style="bottom: -200px;">
    <a href="#" class="link w-1/2">
        <div class="px-6 w-full rounded-md bg-white py-2 shadow-2xl flex items-center">
            <div class="mr-5">
                @include('icons.bell')
            </div>
            <div>
                <h5 class="text-lg font-semibold header">Nowy alert</h5>
                <div class="content">Przejdź dalej</div>
            </div>
        </div>
    </a>
</div>

@push('scripts')
    @include('layouts.partials.pusher')
    <script>
        const showNotification = (element, eventData) => {
            const header = element.querySelector('.header');
            const content = element.querySelector('.content');
            const link = element.querySelector('.link');
            header.innerText = eventData.header
            content.innerText = eventData.message;
            link.setAttribute('href', eventData.url);
            element.classList.add('slide-in-bottom');
        }

        window.addEventListener('load', function () {
            const applicationNotification = document.getElementById('applicationNotification');
            let channel = pusher.subscribe('application_notifications');

            channel.bind('application_notification_sent', function (data) {
                showNotification(applicationNotification, data);
            });
        });
    </script>
@endpush
