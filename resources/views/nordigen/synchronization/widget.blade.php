@push('styles')
    <style>
        #syncButton {
            transition: 0.3s;
            outline: none;
        }

        #syncButton:active {
            margin-left: 0.4rem;
        }
    </style>
@endpush

<button id="syncButton" class="flex mt-1 loading">
    <span id="spinnerIcon" class="mr-1">
        @include('icons.refresh')
    </span>
    <span id="syncButtonText">
        Synchronizuj
    </span>
</button>

@push('scripts')
    <script>
        /** Scope **/
        const syncButton = document.getElementById('syncButton');
        const spinnerIcon = document.getElementById('spinnerIcon');
        const syncButtonText = document.getElementById('syncButtonText');
        const synchronizationRoute = "{{ route('api.analysis') }}";
        const agreementId = "{{ $agreement->id }}";

        /** API Calls **/
        const triggerSynchronization = () => {
            if (syncButton.disabled) return false;

            try {
                fetch("{{ route('api.sync') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'Accept-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            'agreement_id': agreementId
                        })
                    }
                )
                    .then(res => {
                        if (res.ok) {
                            handleRequestSuccess()
                        } else {
                            handleRequestError(res);
                        }
                    })
            } catch (e) {
                handleRequestError();
            }
        }

        /** UI Updates **/
        const handleSyncButtonClick = () => {
            syncButtonText.innerText = 'Synchronizuję...';
            syncButton.classList.add('text-gray-500');
            spinnerIcon.classList.add('animate-spin');
            syncButton.disabled = true;
        }

        const handleRequestError = (res) => {
            console.log(res)
            const mapping = {
                500: 'Wewnętrzny błąd serwera',
                429: 'Przekroczono dzienny limit synchronizacji dla instytucji',
                408: 'Żądanie zajęło zbyt długo'
            };
            try {
                syncButtonText.innerText = mapping[res.status];
            } catch(e) {
                syncButtonText.innerText = 'Nieznany błąd';
            }
            syncButton.classList.add('text-red-600');
            syncButton.classList.add('font-semibold');
            spinnerIcon.style.display = 'none';
        }

        const handleRequestSuccess = () => {
            syncButtonText.innerText = 'Zsynchronizowano';
            syncButton.classList.add('text-indigo-600');
            syncButton.classList.add('font-semibold');
            spinnerIcon.style.display = 'none';
        }

        /** Event Listeners **/
        syncButton.addEventListener('click', () => {
            triggerSynchronization();
            handleSyncButtonClick();
        });
    </script>
@endpush