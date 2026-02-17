<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <h2 class="text-3xl font-black text-white tracking-tight">
                {{ __('Calendrier') }}
            </h2>
            <div class="flex items-center gap-2 bg-[#0a0f1e] p-1.5 rounded-2xl border border-white/5 shadow-2xl">
                <a href="{{ route('calendar.index', ['year' => $currentDate->copy()->subMonth()->year, 'month' => $currentDate->copy()->subMonth()->month]) }}"
                   class="p-3 bg-black/40 text-slate-400 hover:text-white rounded-xl transition-all border border-white/0 hover:border-white/10 active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="px-6 text-[11px] font-bold text-white uppercase tracking-[0.2em]">
                    {{ $currentDate->locale('fr')->isoFormat('MMMM YYYY') }}
                </span>
                <a href="{{ route('calendar.index', ['year' => $currentDate->copy()->addMonth()->year, 'month' => $currentDate->copy()->addMonth()->month]) }}"
                   class="p-3 bg-black/40 text-slate-400 hover:text-white rounded-xl transition-all border border-white/0 hover:border-white/10 active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-0">
        <div class="max-w-[1520px] mx-auto space-y-10">
            
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] overflow-hidden shadow-2xl">
                
                <!-- Calendar Header -->
                <div class="grid grid-cols-7 bg-black/20 border-b border-white/5">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                        <div class="p-6 text-center text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] border-r border-white/5 last:border-r-0">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>
                
                <!-- Calendar Body -->
                @foreach($weeks as $week)
                    <div class="grid grid-cols-7 border-b border-white/5 last:border-b-0">
                        @foreach($week as $day)
                            <div @class([
                                'min-h-[160px] p-4 border-r border-white/5 last:border-r-0 transition-colors duration-300 relative group',
                                'bg-black/10' => !$day['isCurrentMonth'],
                                'bg-blue-500/5' => $day['isToday'],
                                'hover:bg-white/5' => $day['isCurrentMonth'] && !$day['isToday']
                            ])>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <span @class([
                                        'text-xs font-bold tracking-widest',
                                        'text-slate-700' => !$day['isCurrentMonth'],
                                        'text-blue-500 scale-125' => $day['isToday'],
                                        'text-slate-400 group-hover:text-white' => $day['isCurrentMonth'] && !$day['isToday']
                                    ])>
                                        {{ $day['date']->day }}
                                    </span>
                                    @if($day['isToday'])
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)]"></span>
                                    @endif
                                </div>
                                
                                <!-- Assignments -->
                                <div class="space-y-2">
                                    @foreach($day['assignments'] as $assignment)
                                        <div @class([
                                            'text-[9px] font-bold p-2.5 rounded-xl truncate leading-tight border transition-transform hover:scale-105 cursor-pointer shadow-lg outline outline-1 outline-white/0 hover:outline-white/5 uppercase tracking-tighter',
                                            'bg-red-500/10 text-red-500 border-red-500/20' => $assignment->priority === 'high',
                                            'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' => $assignment->priority === 'medium',
                                            'bg-blue-500/10 text-blue-500 border-blue-500/20' => $assignment->priority === 'low',
                                        ])
                                            title="{{ $assignment->title }} ({{ $assignment->subject }})">
                                            {{ \Illuminate\Support\Str::limit($assignment->title, 15) }}
                                        </div>
                                    @endforeach
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                @endforeach
                
            </div>
            
            <!-- Legend -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[2.5rem] p-8 shadow-2xl">
                <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-6">Légende</h3>
                <div class="flex flex-wrap gap-8">
                    <div class="flex items-center group">
                        <div class="w-4 h-4 bg-red-500/20 border border-red-500/30 rounded-lg mr-3 shadow-lg group-hover:scale-110 transition-transform"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Priorité Critique</span>
                    </div>
                    <div class="flex items-center group">
                        <div class="w-4 h-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg mr-3 shadow-lg group-hover:scale-110 transition-transform"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Priorité Normale</span>
                    </div>
                    <div class="flex items-center group">
                        <div class="w-4 h-4 bg-blue-500/20 border border-blue-500/30 rounded-lg mr-3 shadow-lg group-hover:scale-110 transition-transform"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Priorité Faible</span>
                    </div>
                    <div class="flex items-center group">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3 shadow-[0_0_10px_rgba(59,130,246,0.8)]"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aujourd'hui</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
