<table class="w-full divide-y divide-gray-200 overflow-x-scroll">
    <tbody class="bg-white divide-y divide-gray-200">
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Hostname:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.hostname', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>System:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.system', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Release:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.release', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Machine:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.machine', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Uptime:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.uptime', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Processor:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.processor', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Distribution:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.distribution', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>CPU Cores:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.cpu_cores', 'N/A') }}
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Memory:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.memory', 'N/A') }}B
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap">
            <strong>Swap Memory:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            {{ data_get($meta, 'system_info.swap_memory', 'N/A') }}B
        </td>
    </tr>
    <tr>
        <td class="py-2 whitespace-nowrap flex items-start">
            <strong>Kernel Parameters:</strong>
        </td>
        <td class="py-2 whitespace-nowrap">
            @php
                $kernelParametersString = data_get($meta, 'system_info.kernel_parameters', 'N/A');
                $kernelParams = explode(' ', $kernelParametersString);
                $kernelParams = array_filter($kernelParams, function($param) {
                        return trim($param);
                    }
                );
            @endphp
            @foreach($kernelParams as $param)
                • {{ $param }}<br>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>
