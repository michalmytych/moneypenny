

<div class="w-full bg-gray-100 p-8 text-gray-500 rounded-md shadow-sm fade-in">
    <h1 class="text-2xl font-bold mb-2">{{ $fileName }}</h1>
    <p>Video file</p>
    <div class="mt-2">
        <video height="300" controls class="w-full rounded-md">
            <source src="{{ $src ?? '' }}" type="video/{{ $fileExtension }}">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
