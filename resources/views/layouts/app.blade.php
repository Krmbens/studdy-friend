<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Theme CSS -->
        <link rel="stylesheet" href="{{ asset('css/custom-theme.css') }}">

        <!-- Google Fonts for Arabic Support -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Tajawal:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @livewireStyles

        <style>
            body {
                font-family: 'Inter', 'Tajawal', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-black text-gray-200">
        <!-- Flash Message Notification -->
        <div x-data="{ show: false, message: '', type: 'success' }" 
             x-show="show" 
             x-transition
             @flash-message.window="
                 show = true; 
                 message = $event.detail.message; 
                 type = $event.detail.type || 'success';
                 setTimeout(() => show = false, 3000)
             "
             x-cloak
             class="fixed top-4 right-4 z-[100] max-w-md">
            <div class="rounded-xl shadow-2xl p-4 backdrop-blur-md border border-white/10"
                 :class="{
                     'bg-blue-500/20 text-blue-400': type === 'success' || type === 'info',
                     'bg-red-500/20 text-red-400': type === 'error',
                     'bg-yellow-500/20 text-yellow-500': type === 'warning',
                 }">
                <div class="flex items-center">
                    <span x-text="message"></span>
                </div>
            </div>
        </div>

        <div class="min-h-screen">
            @include('layouts.navigation')

            <div class="lg:pl-72 transition-all duration-300">
                <div class="p-4 md:p-8 mt-20 max-w-[1600px] mx-auto">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="mb-8">
                            <div>
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #27272a;
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #3f3f46;
            }

            /* Global Font and Base Overrides */
            body {
                font-family: 'Inter', 'Tajawal', sans-serif;
                letter-spacing: -0.01em;
            }

            [x-cloak] { display: none !important; }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>
        @livewireScripts
    </body>
</html>
