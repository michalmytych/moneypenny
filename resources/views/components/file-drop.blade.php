<div class="pt-2 pb-2">
    <label
        class="flex justify-center w-full h-32 px-4 transition bg-gray-50 border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
        <div class="flex flex-col justify-center items-center">
            <span class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2" width="30" height="30">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span class="font-medium text-gray-600">
                    Przerzuć plik tutaj, lub
                    <span class="text-indigo-600 hover:underline">przeglądaj pliki na urządzeniu</span>
                </span>
            </span>

            <span class="font-semibold text-gray-700" id="fileNamePreview{{ $fileInputName }}"></span>
        </div>

        <input type="file" name="{{ $fileInputName }}" id="fileInput{{ $fileInputName }}" class="hidden">
    </label>
</div>

<script>
    window.addEventListener('load', () => {
        const fileNamePreviewId = "fileNamePreview{{ $fileInputName }}";
        const fileInputId = "fileInput{{ $fileInputName }}";

        const fileInput = document.getElementById(fileInputId);
        const fileNamePreview = document.getElementById(fileNamePreviewId);

        fileInput.addEventListener('change', (e) => {
            const firstFile = e.target.files[0];
            if (!firstFile) return false;
            console.log(firstFile)
            fileNamePreview.innerText = firstFile.name;
        }, false);
    });
</script>
