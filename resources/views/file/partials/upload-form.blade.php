<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="file" class="block font-bold">Select a file to upload:</label>
        <input type="file" name="file" id="file" class="px-4 py-2 rounded-lg w-full">
        <x-input-error :messages="$errors->get('file')" class="mt-2" />
    </div>
    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg">
        Upload
    </button>
</form>
