{{--<div> @todo --}}
{{--    <table class="text-sm w-full rounded-md mt-2 text-black">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th class="text-left">ID</th>--}}
{{--            <th class="text-left">Name</th>--}}
{{--            <th class="text-left">queued_at</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody id="jobsContainer"></tbody>--}}
{{--    </table>--}}
{{--    <div class="text-red-500 font-semibold mt-2" id="topProcessesErrorDisplay"></div>--}}
{{--</div>--}}

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        function createJobAppend(job) {--}}
{{--            return '<tr>' +--}}
{{--                `<td>${job.id}</td>` +--}}
{{--                `<td>${job.name}</td>` +--}}
{{--                `<td>${job.queued_at}</td>`;--}}
{{--        }--}}

{{--        const refreshJobs = () => {--}}
{{--            const jobsContainer = document.getElementById("jobsContainer");--}}
{{--            jobsContainer.innerHTML = '';--}}

{{--            fetch("{{ route('api.meta.jobs') }}", {--}}
{{--                    headers: {--}}
{{--                        "Content-Type": "application/json",--}}
{{--                        'Accept-Type': 'application/json',--}}
{{--                        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),--}}
{{--                        'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`--}}
{{--                    },--}}
{{--                }--}}
{{--            )--}}
{{--                .then(res => res.json())--}}
{{--                .then(jobs => {--}}
{{--                    jobs.forEach(job => {--}}
{{--                        const jobAppend = createJobAppend(job, jobsContainer);--}}
{{--                        jobsContainer.innerHTML += jobAppend;--}}
{{--                    });--}}
{{--                })--}}
{{--        };--}}

{{--        window.addEventListener('load', () => {--}}
{{--            refreshJobs();--}}
{{--            setInterval(() => refreshJobs(), 5000);--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
