<div>
    <table class="text-sm w-full rounded-md mt-2 text-black">
        <thead>
        <tr>
            <th class="text-left">COMMAND</th>
            <th class="text-left">CPU</th>
            <th class="text-left">MEM</th>
            <th class="text-left">USER</th>
            <th class="text-left">PID</th>
            <th class="text-left">TIME</th>
            <th class="text-left">NI</th>
            <th class="text-left">PR</th>
            <th class="text-left">RES</th>
            <th class="text-left">S</th>
            <th class="text-left">SHR</th>
            <th class="text-left">VIRT</th>
        </tr>
        </thead>
        <tbody id="processesDisplay"></tbody>
    </table>
    <div class="text-red-500 font-semibold mt-2" id="topProcessesErrorDisplay"></div>
</div>

@push('scripts')
    <script>
        const processesDisplay = document.getElementById('processesDisplay');
        const topProcessesErrorDisplay = document.getElementById('topProcessesErrorDisplay');
        const metaProcessesRoute = "{{ route('api.meta.processes') }}";

        const displayData = (data) => {
            processesDisplay.innerHTML = '';

            if (!data || !data.processes) {
                topProcessesErrorDisplay.innerHTML = 'Error while fetching server processes.';
                return;
            }

            topProcessesErrorDisplay.innerHTML = '';

            data.processes.forEach(item => {
                const append = '<tr>' +
                    `<td>${item.COMMAND}</td>` +
                    `<td>${item.CPU}</td>` +
                    `<td>${item.MEM}</td>` +
                    `<td>${item.USER}</td>` +
                    `<td>${item.PID}</td>` +
                    `<td>${item.TIME}</td>` +
                    `<td>${item.NI}</td>` +
                    `<td>${item.PR}</td>` +
                    `<td>${item.RES}</td>` +
                    `<td>${item.S}</td>` +
                    `<td>${item.SHR}</td>` +
                    `<td>${item.VIRT}</td>` +
                    '</tr>';
                processesDisplay.innerHTML += append;
            });
        }

        const fetchData = () => {
            fetch(metaProcessesRoute, {
                headers: {
                    'Accept-Type': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                    'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                }})
                .then(res => res.json())
                .then(json => displayData(json))
                .catch(error => {
                    displayData(false);
                    console.error(error);
                })
        };

        window.addEventListener('load', () => {
            setInterval(fetchData, 1500);
        });

    </script>
@endpush
