<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Studdy-Freind') }} | Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;400;700;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glow-mesh {
            background: 
                radial-gradient(at 0% 0%, hsla(215, 60%, 10%, 1) 0, transparent 50%), 
                radial-gradient(at 50% 100%, hsla(220, 50%, 20%, 1) 0, transparent 50%);
        }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 antialiased selection:bg-blue-500/30">
    <div class="fixed inset-0 glow-mesh z-0 opacity-60"></div>

    <div class="min-h-screen relative z-10 flex flex-col items-center justify-center p-6">
        <div class="mb-12 flex flex-col items-center">
            <a href="/" class="group">
                <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center shadow-xl shadow-blue-500/20 group-hover:scale-105 transition-transform mb-4">
                    <span class="font-black text-2xl tracking-tighter text-white">SF</span>
                </div>
            </a>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Espace Étudiant</h2>
        </div>

        <div class="w-full sm:max-w-md p-10 bg-slate-900/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>

        <div class="mt-8">
            <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-600 leading-relaxed text-center">
                Studdy-Freind // Votre allié pour la réussite<br>
                Plateforme d'aide aux études v4.2
            </p>
        </div>
    </div>
</body>
</html>
