<div class="container mx-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-200">
        <tr class="bg-gray-200">
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-md">
                Nazwa tabeli
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-md">
                Rozmiar (MB)
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tablesData as $table)
            <tr class="divide-y divide-gray-200 rounded">
                <td class="px-4 py-2">
                    {{ $table->table }}
                </td>
                <td class="px-4 py-2">
                    {{ $table->size_MB }}MB
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
