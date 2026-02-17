<!-- Top Navbar -->
<nav class="fixed top-0 left-0 lg:left-72 z-40 w-full lg:w-[calc(100%-18rem)] px-4 pt-4 transition-all duration-300">
    <div class="max-w-[1520px] mx-auto flex items-center justify-between h-14 px-4 rounded-2xl bg-[#0a0f1e]/50 backdrop-blur-xl border border-white/5">
        <div class="flex items-center gap-6">
            <!-- Global Search -->
            <livewire:global-search />
        </div>

        <div class="flex items-center gap-6">
            <!-- User Profile -->
            <div class="flex items-center gap-3 pl-6 border-l border-white/5">
                <div class="hidden md:block text-right">
                    <p class="text-xs font-bold text-white leading-tight uppercase tracking-wider">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-slate-600 uppercase tracking-widest font-bold">Session Active</p>
                </div>
                <button type="button" class="flex text-sm bg-slate-800 rounded-xl focus:ring-2 focus:ring-white/10 transition-transform active:scale-95" id="dropdown-user-btn" data-dropdown-toggle="dropdown-user">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/20">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- User Dropdown -->
    <div class="z-50 hidden my-4 text-base list-none bg-[#0c0c0d] border border-white/10 divide-y divide-white/5 rounded-2xl shadow-2xl" id="dropdown-user">
        <div class="px-4 py-3">
            <p class="text-sm text-white font-bold">{{ Auth::user()->name }}</p>
            <p class="text-xs font-medium text-slate-500 truncate">{{ Auth::user()->email }}</p>
        </div>
        <ul class="py-1">
            <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-400 hover:bg-white/5 hover:text-white transition-colors">Paramètres du profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-400/80 hover:bg-red-500/5 hover:text-red-400 transition-colors">Déconnexion</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<!-- Expanded Left Sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-50 w-72 h-screen pt-4 transition-transform -translate-x-full lg:translate-x-0 bg-[#0a0f1e]" aria-label="Sidebar">
    <div class="h-full px-4 pb-8 overflow-y-auto bg-transparent flex flex-col">
        <!-- Minimal App Identity -->
        <div class="mb-10 mt-2 px-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-white font-black text-sm tracking-tighter">STUDDY-FREIND</h1>
                <p class="text-[9px] text-slate-600 font-bold tracking-widest uppercase">Espace Étudiant</p>
            </div>
        </div>

        <!-- Main Nav -->
        <div class="flex-1 flex flex-col gap-2 w-full">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="grid" label="Tableau de Bord" />
            <x-sidebar-link :href="route('assignments.index')" :active="request()->routeIs('assignments.*')" icon="assignment" label="Devoirs" />
            <x-sidebar-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" icon="calendar" label="Calendrier" />
            <x-sidebar-link :href="route('study-sessions.index')" :active="request()->routeIs('study-sessions.*')" icon="clock" label="Sessions d'Étude" />
            <x-sidebar-link :href="route('pomodoro.index')" :active="request()->routeIs('pomodoro.*')" icon="timer" label="Minuteur" />
            
            <div class="px-6 py-4">
                <div class="h-[1px] bg-white/5 w-full"></div>
            </div>
            
            <x-sidebar-link :href="route('exercise-solver.index')" :active="request()->routeIs('exercise-solver.*')" icon="brain" label="Résolveur d'Exercices" />
            <x-sidebar-link :href="route('ai-tips.index')" :active="request()->routeIs('ai-tips.*')" icon="brain" label="Plan d'Études" />
            <x-sidebar-link :href="route('quiz.index')" :active="request()->routeIs('quiz.*')" icon="quiz" label="Générateur de Quiz" />
            <x-sidebar-link :href="route('summarizer.index')" :active="request()->routeIs('summarizer.*')" icon="summary" label="Résumé de Texte" />
            <x-sidebar-link :href="route('flashcards.index')" :active="request()->routeIs('flashcards.*')" icon="folders" label="Flashcards" />
        </div>

        <!-- Footer Icons -->
        <div class="flex flex-col gap-2 w-full mt-auto">
            <x-sidebar-link :href="route('statistics.index')" :active="request()->routeIs('statistics.*')" icon="stats" label="Statistiques" />
            <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" icon="settings" label="Mon Profil" />
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 text-slate-600 hover:text-red-400 transition-all group/logout">
                    <svg class="w-6 h-6 group-hover/logout:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Overlay and Toggle -->
<div id="mobile-sidebar-toggle" class="fixed bottom-6 right-6 lg:hidden z-[60]">
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" class="p-5 bg-blue-600 rounded-2xl shadow-2xl shadow-blue-500/40 text-white active:scale-90 transition-transform">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2z"/></svg>
    </button>
</div>
