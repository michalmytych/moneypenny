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
        Synchronize
    </span>
</button>

@push('scripts')
    @if($agreement)
        <script>
            /** Scope **/
            const syncButton = document.getElementById('syncButton');
            const spinnerIcon = document.getElementById('spinnerIcon');
            const syncButtonText = document.getElementById('syncButtonText');
            const agreementId = "{{ $agreement->id }}";

            /** API Calls **/
            const triggerSynchronization = () => {
                if (syncButton.disabled) return false;

                try {
                    fetch("{{ route('api.sync.synchronize') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'Accept-Type': 'application/json',
                                'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                                'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
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
                syncButtonText.innerText = 'Synchronizing...';
                syncButton.classList.add('text-gray-500');
                spinnerIcon.classList.add('animate-spin');
                syncButton.disabled = true;
            }

            const handleRequestError = (res) => {
                const mapping = {
                    500: 'Internal server error!',
                    429: 'Daily institution synchronizations limit exceeded!',
                    408: 'Request timed out!'
                };
                try {
                    syncButtonText.innerText = mapping[res.status];
                } catch(e) {
                    syncButtonText.innerText = 'Error occured';
                }
                syncButton.classList.add('text-red-600');
                syncButton.classList.add('font-semibold');
                spinnerIcon.style.display = 'none';
            }

            const handleRequestSuccess = () => {
                syncButtonText.innerText = 'Synchronized';
                syncButton.classList.add('text-indigo-600');
                syncButton.classList.add('font-semibold');
                spinnerIcon.style.display = 'none';
                @if(isset($reload) && $reload)
                window.setTimeout(function() {
                    window.location.reload();
                }, 1000);
                @endif
            }

            /** Event Listeners **/
            syncButton.addEventListener('click', () => {
                triggerSynchronization();
                handleSyncButtonClick();
            });
        </script>
    @endif
@endpush
