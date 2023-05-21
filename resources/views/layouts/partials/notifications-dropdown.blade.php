<style>
    .dropdown-link {
        display: block;
        padding: 0.5rem 1rem;
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-duration: 150ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        color: #374151;
        font-size: 0.875rem;
        line-height: 1.25rem;
        text-align: left;
        width: 100%;
    }

    .dropdown-link:hover {
        background-color: #F3F4F6;
    }
</style>

<x-dropdown align="right" width="72">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
            <div class="mr-4 font-bold">
                @include('icons.notification-bell')
            </div>
        </button>
    </x-slot>

    <x-slot name="content">

        <div id="notificationsContainer">
            <x-dropdown-link :href="route('profile.edit')">
                <strong>Notification</strong>
                <p>Notification hello</p>
            </x-dropdown-link>
        </div>


        <div class="px-4 font-semibold text-indigo-500 cursor-pointer hover:bg-gray-100">
            <a href="{{ route('notification.index') }}">
                @include('icons.dots')
            </a>
        </div>
    </x-slot>
</x-dropdown>

@push('scripts')
    <script>
        function createNotificationElement(notification) {
            const content = JSON.parse(notification.content);

            const link = document.createElement('a');
            link.classList.add('dropdown-link');

            if (notification.status === {{ \App\Models\Notification::STATUS_READ }}) {
                link.style.opacity = '0.7';
                link.style.borderLeft = '4px solid #9CA3AF';
            } else {
                link.style.borderLeft = '4px solid #6366F1';
            }

            link.setAttribute('href', "{{ route('notification.index') }}");

            const headerElement = document.createElement('strong');
            headerElement.innerText = content.header;
            link.appendChild(headerElement)

            const contentElement = document.createElement('p');
            contentElement.innerText = content.content;
            link.appendChild(contentElement)

            return link;
        }

        window.addEventListener('load', () => {
            const notificationsContainer = document.getElementById("notificationsContainer");
            notificationsContainer.innerHTML = '';

            fetch("{{ route('api.notification.index') }}", {
                    headers: {
                        "Content-Type": "application/json",
                        'Accept-Type': 'application/json',
                        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                        'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                    },
                    query: {limit: 7}
                }
            )
                .then(res => res.json())
                .then(json => {
                    const notifications = json.notifications;
                    notifications.forEach(notification => {
                        const link = createNotificationElement(notification);
                        notificationsContainer.appendChild(link);
                    });
                })
        });
    </script>
@endpush
