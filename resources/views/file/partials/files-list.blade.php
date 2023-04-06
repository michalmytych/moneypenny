<div class="text-black px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Files</h1>
    <table class="w-full">
        <thead>
            <tr>
                <th class="text-left">#</th>
                <th class="text-left">Name</th>
                <th class="text-left">Size</th>
                <th class="text-left">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td class="py-2">{{ $file->id }}</td>
                    <td class="py-2">{{ $file->name }}</td>
                    <td class="py-2">{{ $file->size }} bytes</td>
                    <td class="py-2">{{ $file->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
