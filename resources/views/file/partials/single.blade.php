<div class="text-black p-4 rounded-md">
    <h2 class="text-3xl mb-4 font-bold">{{ $file->name }}</h2>
    <p><strong>Nazwa pliku:</strong> {{ $file->name }}</p>
    <p>
        <strong>Rozmiar pliku:</strong>
        @include('components.storage-size-display', ['size' => $file->size])
    </p>
    <p><strong>Data dodania:</strong> {{ $file->created_at }}</p>
</div>
