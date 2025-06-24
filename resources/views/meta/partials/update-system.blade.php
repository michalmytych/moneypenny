<div class="mb-4">

    <div class="rounded-md bg-white p-4 shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-black">Update System</h1>
        <div class="text-lg font-bold text-black">Configured host</div>
        <div class="flex items-center pb-2">
            <div
                style="display: inline-block; width: 10px; height: 10px; background-color: #22c55e; border-radius: 50%; margin-right: 0.5rem; margin-top: 2px;">
            </div>
            <div>
                {{ config('admin-ssh.host') }}
            </div>
        </div>
        <button id="run-update"
            class="bg-indigo-600 hover:bg-indigo-800 disabled:bg-indigo-400 text-white font-semibold py-2 px-6 rounded-lg mb-4 shadow transition duration-200">
            Run platform update
        </button>

        <div id="output"
            class="block font-mono text-sm leading-relaxed bg-indigo-900 text-white p-4 rounded-xl whitespace-pre-wrap border border-indigo-300 shadow-sm"
            style="font-family: monospace; background-color: black; height: 200px; overflow-y: auto; font-size: 12px;">Waiting for commands</div>
    </div>

</div>

<script>
    document.getElementById('run-update').addEventListener('click', async () => {
        document.getElementById('run-update').disabled = true;
        document.getElementById('run-update').innerHTML = 'Update is running'
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
                        <div class="text-indigo-300 font-semibold mb-2" style="font-family: monospace; background-color: black;">Executed Commands:</div>`;
            data.results.forEach(result => {
                html += `<div class="mb-2" style="font-family: monospace; background-color: black;">
                            <div class="text-indigo-400" style="font-family: monospace; background-color: black;">› ${result.command}</div>
                            <pre class="text-white ml-2" style="font-family: monospace; background-color: black;">${result.output.map(line => line.trim()).join('\n')}</pre>
                         </div>`;
            });
            html += `</div>`;

            // Render connection log
            html += `<div class="mt-4 border-t border-indigo-700 pt-4" style="font-family: monospace; background-color: black;">
                        <div class="text-indigo-300 font-semibold mb-2">Connection Log:</div>
                        <ul class="list-disc list-inside text-gray-300 text-sm" style="font-family: monospace; background-color: black;">`;
            data.connection_log.forEach(line => {
                html += `<li style="font-family: monospace; background-color: black;">${line}</li>`;
            });
            html += `</ul></div>`;

            codeBlock.innerHTML = html;
            document.getElementById('run-update').disabled = false;

        } catch (error) {
            codeBlock.innerHTML = `<span class="text-red-400">Error: ${error.message}</span>`;
        }
    });
</script>
