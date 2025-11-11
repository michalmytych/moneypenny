<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moneypenny – Zarządzaj swoimi finansami</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            @keyframes fade-in-right {
                0% {
                    opacity: 0;
                    transform: translateX(120px);
                }
                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes fade-in-right-half {
                0% {
                    transform: translateX(120px);
                }
                100% {
                    transform: translateX(0);
                }
            }
            .animate-fade-in-right {
                animation: fade-in-right 1s cubic-bezier(.3,.22,.36,1.18) forwards;
            }
            .animate-fade-in-right-slower {
                animation: fade-in-right 1.18s cubic-bezier(.3,.22,.36,1.18) forwards;
            }
            .animate-fade-in-delayed {
                animation: fade-in-right-half 1.5s cubic-bezier(.3,.22,.36,1.18) forwards;
            }
        }
    </style>
</head>
<body class="m-0 p-0 overflow-hidden text-white cursor-none">

    <!-- Wideo w tle -->
    <video id="bg-video" class="fixed top-0 left-0 w-full h-full object-cover z-0" autoplay muted loop playsinline>
        <source src="{{ asset('welcome.mp4') }}" type="video/mp4">
        Twoja przeglądarka nie obsługuje tagu wideo.
    </video>

    <!-- Maska podczas ładowania -->
    <div id="video-overlay" class="fixed top-0 left-0 w-full h-full bg-black z-10 flex items-center justify-center transition-opacity duration-700"></div>

    <!-- Gradient ukośny -->
    <div class="fixed top-0 left-0 w-full h-full bg-gradient-to-br from-black/60 to-transparent z-10 pointer-events-none"></div>

    <!-- Główna treść z animacjami -->
    <div class="relative z-20 flex flex-col justify-center h-screen px-6 md:px-16 text-left">
        <h1 class="text-7xl md:text-7xl font-extrabold mb-6 bg-gradient-to-r from-white to-indigo-400 bg-clip-text text-transparent drop-shadow-xl animate-fade-in-right">
            <div class="flex items-center">
                <div class="mr-6">@include('icons.logo-lg')</div>
                Moneypenny
            </div>
        </h1>

        <p class="text-lg max-w-lg drop-shadow-md animate-fade-in-right-slower">
            Moneypenny to Twoja osobista platforma do zarządzania finansami. Pomaga śledzić wydatki, planować budżet i podejmować mądre decyzje finansowe – przejrzyście, intuicyjnie i bez stresu.
        </p>

        <!-- Przycisk "Wejdź" z ikoną -->
        <a href="{{ route('login') }}"
           class="cursor-none animate-fade-in-delayed mt-8 w-fit px-6 py-3 rounded-xl backdrop-blur-md bg-white/10 text-white/70 text-lg font-medium opacity-50 hover:opacity-100 active:scale-110 transition duration-300 shadow-md flex items-center gap-2">
            Wejdź
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Niestandardowy kursor ↖ -->
    <div id="custom-cursor" class="fixed top-0 left-0 z-50 pointer-events-none transition-transform duration-200 ease-out">
        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 text-white/70 text-xl font-semibold shadow-md backdrop-blur-sm">
            ↖
        </div>
    </div>

    <!-- Skrypty -->
    <script>
        const video = document.getElementById('bg-video');
        const overlay = document.getElementById('video-overlay');

        video.addEventListener('canplay', () => {
            overlay.classList.add('opacity-30');
        });

        // Smooth cursor
        const cursor = document.getElementById("custom-cursor");
        let mouseX = 0;
        let mouseY = 0;
        let currentX = 0;
        let currentY = 0;

        document.addEventListener("mousemove", (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animateCursor() {
            const speed = 0.12;
            currentX += (mouseX - currentX) * speed;
            currentY += (mouseY - currentY) * speed;
            cursor.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
            requestAnimationFrame(animateCursor);
        }

        animateCursor();
    </script>

    @include('layouts.partials.fixed-footer')
</body>
</html>
