<div class="relative lg:block" x-data="{ open: @entangle('showDropdown') }" @click.away="open = false">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    <input type="text" 
           wire:model.live.debounce.300ms="search"
           @focus="open = true"
           class="bg-[#1e1e21]/50 border-0 text-sm rounded-xl focus:ring-1 focus:ring-white/10 block w-96 pl-10 p-2 text-slate-300 placeholder-slate-500 transition-all duration-300 focus:w-full lg:focus:w-[500px]" 
           placeholder="Rechercher des devoirs, sessions ou conseils...">

    <div wire:loading class="absolute right-3 top-2.5">
        <div class="w-4 h-4 border-2 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div x-show="open && $wire.search.length >= 2" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute left-0 mt-4 w-full lg:w-[500px] bg-[#121214] border-2 border-purple-500 rounded-2xl shadow-2xl z-50 overflow-hidden backdrop-blur-xl"
         x-cloak>
        
        <div class="max-h-[400px] overflow-y-auto">
            @if(count($results ?? []) > 0)
                <div class="p-2 border-b border-white/5 bg-white/5">
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest px-3 py-1">Résultats trouvés</p>
                </div>
                <div class="divide-y divide-white/5">
                    @foreach($results as $result)
                        <a href="{{ $result['url'] }}" class="flex items-center gap-4 px-4 py-3 hover:bg-white/5 transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 group-hover:text-blue-400 border border-white/5 transition-colors">
                                @if($result['icon'] == 'assignment')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                @elseif($result['icon'] == 'brain')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                @elseif($result['icon'] == 'quiz')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($result['icon'] == 'clock')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ $result['title'] }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">{{ $result['type'] }}</span>
                                    <span class="text-[9px] text-white/20">•</span>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest truncate">{{ $result['subtitle'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center opacity-30">
                    <p class="text-[10px] font-bold uppercase tracking-widest">Aucun résultat trouvé</p>
                </div>
            @endif
        </div>
    </div>
</div>
