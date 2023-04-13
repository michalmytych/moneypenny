<div class="lg:grid lg:grid-cols-3">
    <div class="col-1">
        <h2 class="text-lg font-semibold">Dzisiaj do wydania</h2>
        <div class="flex">
            <h1 id="totalDisplay" class="text-7xl text-semibold">190.00</h1>
            <span class="text-xl ml-2">PLN</span>
        </div>
    </div>

    <div class="pr-4 sm:md:my-2">
        <div class="h-10 rounded-md w-full bg-gray-200 mb-4 flex items-center pl-3 hover:scale-105 cursor-pointer transform-gpu transition duration-150 ease-out hover:ease-in">
            @include('icons.sync')
            <span class="text-black-50 text-xs ml-3">
                <span class="font-black">Nowa synchronizacja</span>, dodano 3 transakcje
            </span>
        </div>
        <div class="h-10 rounded-md w-full bg-gray-200 mb-4 flex items-center pl-3 hover:scale-105 cursor-pointer transform-gpu transition duration-150 ease-out hover:ease-in">
            @include('icons.eye')
            <span class="text-black-50 text-xs ml-3">
                <span class="font-black">20 transakcji</span> wymaga uwagi
            </span>
        </div>
        <div class="h-10 rounded-md w-full bg-gray-200 mb-4 flex items-center pl-3 hover:scale-105 cursor-pointer transform-gpu transition duration-150 ease-out hover:ease-in">
            @include('icons.report')
            <span class="text-black-50 text-xs ml-3">
                <span class="font-black">Nowy raport:</span> kwiecień 2023
            </span>
        </div>
        <div class="h-10 rounded-md w-full bg-gray-200 mb-4 flex items-center pl-3 hover:scale-105 cursor-pointer transform-gpu transition duration-150 ease-out hover:ease-in">
            @include('icons.report')
            <span class="text-black-50 text-xs ml-3">
                <span class="font-black">Nowy raport:</span> marzec 2023
            </span>
        </div>
    </div>

    <div>
        <ul id="fadeInList" class="list-none sm:md:mr-4 sm:md:my-2">
            <div class="flex items-center mb-2">
                <div class="text-sm w-1/2 text-right mr-4 font-semibold text-gray-700">Budżet domowy</div>
                <li class="bg-gray-200 rounded-md w-1/2" style="height: 9px;">
                    <div id="i0" class="bg-indigo-600 rounded-md mb-4" style="height: 9px;"></div>
                </li>
            </div>

            <div class="flex items-center mb-2">
                <div class="text-sm w-1/2 text-right mr-4 font-semibold text-gray-700">Kredyt hipoteczny</div>
                <li class="bg-gray-200 rounded-md w-1/2" style="height: 9px;">
                    <div id="i1" class="bg-indigo-600 rounded-md mb-4" style="height: 9px;"></div>
                </li>
            </div>

            <div class="flex items-center mb-2">
                <div class="text-sm w-1/2 text-right mr-4 font-semibold text-gray-700">Oszczędnościowy</div>
                <li class="bg-gray-200 rounded-md w-1/2" style="height: 9px;">
                    <div id="i2" class="bg-indigo-600 rounded-md mb-4" style="height: 9px;"></div>
                </li>
            </div>

            <div class="flex items-center mb-2">
                <div class="text-sm w-1/2 text-right mr-4 font-semibold text-gray-700">Inwestycje giełdowe</div>
                <li class="bg-gray-200 rounded-md w-1/2" style="height: 9px;">
                    <div id="i3" class="bg-indigo-600 rounded-md mb-4" style="height: 9px;"></div>
                </li>
            </div>

            <div class="flex items-center mb-2">
                <div class="text-sm w-1/2 text-right mr-4 font-semibold text-gray-700">Plan emerytalny</div>
                <li class="bg-gray-200 rounded-md w-1/2" style="height: 9px;">
                    <div id="i4" class="bg-indigo-600 rounded-md mb-4" style="height: 9px;"></div>
                </li>
            </div>
        </ul>
    </div>
</div>

@push('scripts')
    <script>
        function animateToValue(elementId, targetValue) {
            const element = document.getElementById(elementId);
            let value = 0;
            const targetIntValue = targetValue * 100;
            const duration = 800;

            function animate(timestamp) {
                const progress = Math.min(1, (timestamp - startTime) / duration);
                value = Math.floor(progress * targetIntValue);
                element.innerHTML = (value / 100).toFixed(2);
                element.style.opacity = progress;

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            let startTime = performance.now();
            element.style.opacity = 0;
            requestAnimationFrame(function (timestamp) {
                startTime = timestamp;
                element.style.display = 'block';
                requestAnimationFrame(animate);
            });
        }

        function animateLoader(elementId, targetValue) {
            const loaderWidth = 120;
            const duration = 800;

            const targetWidth = (targetValue / 100) * loaderWidth;
            const elementNode = document.getElementById(elementId);

            function animate(timestamp) {
                const progress = Math.min(1, (timestamp - startTime) / duration);
                const width = progress * targetWidth;
                elementNode.style.width = width + 'px';

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            let startTime = performance.now();
            elementNode.style.width = '0';
            requestAnimationFrame(function (timestamp) {
                startTime = timestamp;
                elementNode.style.display = 'block';
                requestAnimationFrame(animate);
            });
        }

        window.addEventListener('load', () => {
                animateToValue('totalDisplay', 199.00);
                animateLoader('i0', 20);
                animateLoader('i1', 30);
                animateLoader('i2', 65);
                animateLoader('i3', 10);
                animateLoader('i4', 60);
            }
        );
    </script>
@endpush
