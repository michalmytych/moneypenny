<div class="text-white z-20 bg-indigo-600 font-light py-1 flex justify-center w-full items-center fixed bottom-0">
    {{ config('release_notes.current_version') }}
    <span class="text-xl font-semibold mx-2">•</span>
    <a href="{{ route('version.release_notes') }}" class="hover:underline">Release notes</a>
</div>
