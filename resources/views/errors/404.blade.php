<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-900 text-white min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob"></div>
    <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 text-center px-6 w-full max-w-4xl mx-auto">
        <h1 class="text-[8rem] sm:text-[10rem] lg:text-[12rem] font-black leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 drop-shadow-2xl select-none">
            404
        </h1>
        
        <div class="mt-4 sm:mt-8 space-y-4 sm:space-y-6">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-gray-100">
                Oops! Halaman Hilang.
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-400 max-w-2xl mx-auto font-medium">
                Sepertinya kamu tersesat. Halaman yang kamu cari mungkin sudah dihapus, dipindahkan, atau memang tidak pernah ada.
            </p>
        </div>

        <div class="mt-10 sm:mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" 
               class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-full hover:bg-blue-700 hover:shadow-[0_0_30px_rgba(37,99,235,0.4)] hover:-translate-y-1 w-full sm:w-auto">
                <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
            
            <button onclick="history.back()" 
               class="inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-gray-300 transition-all duration-200 bg-gray-800/50 border border-gray-700 rounded-full hover:bg-gray-800 hover:text-white hover:border-gray-500 backdrop-blur-sm w-full sm:w-auto">
                Halaman Sebelumnya
            </button>
        </div>
    </div>
</body>
</html>
