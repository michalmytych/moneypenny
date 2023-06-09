<div id="debugError" class="fixed left-1/3 bg-red-100 border-4 border-red-500 rounded-md shadow-2xl z-50 p-2 w-1/3"
     style="top: -10rem;">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-xl font-bold text-red-500">
                API Request failed
            </h1>
            <div class="responseStatus font-bold text-lg">Unknown status</div>
        </div>
        <div class="debugErrorClose hoverScaleBoxXL cursor-pointer text-red-500">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
    </div>
    <div class="responseURL text-sm text-gray-600 font-light"></div>
    <div class="responseData text-sm text-gray-600 font-light">
        Error occured!
    </div>
</div>
