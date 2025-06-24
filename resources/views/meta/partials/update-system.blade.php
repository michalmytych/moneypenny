<div class="mb-4">

    <div class="rounded-md bg-white p-4 shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-black">Update System</h1>
        <div class="text-lg font-bold text-black">Configured host</div>
        <div class="flex items-center pb-2">
            <div
                style="display: inline-block; width: 10px; height: 10px; background-color: #22c55e; border-radius: 50%; margin-right: 0.5rem;">
            </div>
            <div>
                {{ config('admin-ssh.host') }}
            </div>
        </div>
        <button id="run-update"
            class="bg-indigo-600 hover:bg-indigo-800 text-white font-semibold py-2 px-6 rounded-lg mb-4 shadow transition duration-200">
            Run platform update
        </button>

        <div id="output"
            class="block font-mono text-sm leading-relaxed bg-indigo-900 text-white p-4 rounded-xl whitespace-pre-wrap border border-indigo-300 shadow-sm"
            style="font-family: monospace; background-color: black;">
            Waiting for command
        </div>
    </div>

</div>

<script>
    document.getElementById('run-update').addEventListener('click', async () => {
        const updateSystemRoute = "{{ route('api.meta.update_system') }}";
        const codeBlock = document.getElementById('output');
        codeBlock.innerHTML = '<span class="text-yellow-400">Updating system...</span>';

        try {
            const response = await fetch(updateSystemRoute, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                    'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const data = await response.json();
            let html = '';

            // Render commands
            html += `<div class="mb-4">
                        <div class="text-indigo-300 font-semibold mb-2">Executed Commands:</div>`;
            data.results.forEach(result => {
                html += `<div class="mb-2">
                            <div class="text-indigo-400">› ${result.command}</div>
                            <pre class="text-white ml-2">${result.output.map(line => line.trim()).join('\n')}</pre>
                         </div>`;
            });
            html += `</div>`;

            // Render connection log
            html += `<div class="mt-4 border-t border-indigo-700 pt-4">
                        <div class="text-indigo-300 font-semibold mb-2">Connection Log:</div>
                        <ul class="list-disc list-inside text-gray-300 text-sm">`;
            data.connection_log.forEach(line => {
                html += `<li>${line}</li>`;
            });
            html += `</ul></div>`;

            codeBlock.innerHTML = html;

        } catch (error) {
            codeBlock.innerHTML = `<span class="text-red-400">Error: ${error.message}</span>`;
        }
    });
</script>
