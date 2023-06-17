<div class="w-full bg-gray-100 p-8 text-gray-500 rounded-md shadow-sm fade-in">
    <h1 class="text-2xl font-bold mb-2">{{ $fileName }}</h1>
    <p>Image file</p>
    <div class="mt-2">
        <img
            class="rounded-md"
            alt="Image file {{ $fileName }}."
            src="{{ $src ?? '' }}"
        />
    </div>
</div>
