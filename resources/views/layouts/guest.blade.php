<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ayo Behacaar') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body
    class="bg-[#f6f3f2] h-screen overflow-hidden flex flex-col font-sans text-slate-900 antialiased selection:bg-blue-600 selection:text-white">
    <main class="flex-grow flex items-center justify-center px-4 py-12 relative overflow-hidden">
        <div class="w-full max-w-[480px] glass-effect rounded-2xl p-8 md:p-12 z-10 transition-transform duration-500"
            id="login-card">
            <div class="flex flex-col items-center mb-3">
                <img alt="Ayo Behacaar Logo" class="w-28 mb-1" src="{{ asset('assets/img/ayobehacaar.png') }}">
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 font-brand">ayo<span
                        class="text-blue-600">behacaar</span></h1>
            </div>

            {{ $slot }}
        </div>
    </main>
</body>

</html>
