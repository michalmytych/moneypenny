<div id="applicationNotification" class="fixed z-50 flex justify-center w-full transition-all hover:translate-x-1.5"
     style="bottom: -200px;">
    <a href="#" class="link w-full lg:w-1/2 md:w-2/3 sm:w-full flex justify-center">
        <div class="px-6 w-5/6 rounded-md bg-white py-2 shadow-2xl shadow-indigo-400 flex items-center">
            <div class="mr-5">
                @include('icons.bell')
            </div>
            <div>
                <h5 class="text-lg font-semibold header lg:text-lg sm:text-sm">Nowy alert</h5>
                <div class="content">Przejdź dalej</div>
            </div>
        </div>
    </a>
</div>

@push('scripts')
    @include('layouts.partials.pusher')
    <script>
        const element = document.getElementById('applicationNotification');

        const showNotification = (eventData) => {
            const header = element.querySelector('.header');
            const content = element.querySelector('.content');
            const link = element.querySelector('.link');
            header.innerText = eventData.header
            content.innerText = eventData.message;
            link.setAttribute('href', eventData.url);
            element.classList.add('slide-in-bottom');
            setTimeout(() => {
                element.classList.remove('slide-in-bottom');
            }, 7400);
        }

        window.addEventListener('load', function () {
            let channel = pusher.subscribe('application_notifications');

            channel.bind('application_notification_sent', function (data) {
                element.classList.remove('slide-in-bottom');
                showNotification(data);
                console.log(window.refreshNotifications)
                window.refreshNotifications();
            });
        });
    </script>
@endpush
