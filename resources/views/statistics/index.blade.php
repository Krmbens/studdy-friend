<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-3xl font-black text-white tracking-tight">
                {{ __('Statistiques') }}
            </h2>
            <a href="{{ route('statistics.export') }}" 
               class="bg-gradient-to-br from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                📥 {{ __('Exporter en PDF') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-0">
        <div class="max-w-[1520px] mx-auto space-y-10">
            
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <a href="{{ route('assignments.index') }}" class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group block hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl opacity-50 text-blue-500 group-hover:bg-blue-600/20 transition-all"></div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Total des Devoirs</h3>
                    <p class="text-6xl font-black text-white tracking-tighter">{{ $totalAssignments }}</p>
                </a>
                
                <a href="{{ route('assignments.index', ['filter' => 'completed']) }}" class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group block hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-600/10 rounded-full blur-2xl opacity-50 group-hover:bg-emerald-600/20 transition-all"></div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Terminés</h3>
                    <p class="text-6xl font-black text-emerald-500 tracking-tighter">{{ $completedAssignments }}</p>
                </a>
                
                <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl opacity-50"></div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Taux de Réussite</h3>
                    <div class="flex items-baseline gap-2 mb-4">
                        <p class="text-6xl font-black text-blue-500 tracking-tighter">{{ $completionRate }}</p>
                        <span class="text-2xl font-black text-blue-500/50">%</span>
                    </div>
                    <div class="w-full bg-black/40 rounded-full h-3 border border-white/5 shadow-inner">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(59,130,246,0.4)]" 
                             style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
                
            </div>
            
            <!-- Study Time Chart (Last 7 Days) -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] p-12 shadow-2xl">
                <h3 class="text-2xl font-black text-white mb-10 tracking-tight">📊 Temps d'Étude <span class="text-slate-600 opacity-50 font-medium ml-2">7 Derniers Jours</span></h3>
                <div class="space-y-6">
                    @foreach($studyByDay as $day)
                        <div class="flex items-center group">
                            <div class="w-40 text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">
                                {{ \Carbon\Carbon::parse($day->session_date)->locale('fr')->isoFormat('ddd DD/MM') }}
                            </div>
                            <div class="flex-1">
                                <div class="bg-black/40 rounded-3xl h-10 relative border border-white/5 shadow-inner overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-3xl flex items-center justify-end pr-4 transition-all duration-1000 group-hover:brightness-110 shadow-lg" 
                                         style="width: {{ min(($day->total / 300) * 100, 100) }}%">
                                        <span class="text-[9px] text-white font-bold uppercase tracking-widest drop-shadow-lg">
                                            {{ floor($day->total / 60) }}H {{ $day->total % 60 }}M
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($studyByDay->isEmpty())
                        <div class="text-center py-20 bg-black/20 rounded-[2rem] border border-white/5 border-dashed">
                            <p class="text-[10px] font-bold text-slate-700 uppercase tracking-widest">Aucune donnée disponible</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <!-- Top Subjects -->
                <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden">
                    <h3 class="text-2xl font-black text-white mb-8 tracking-tight">🏆 Matières Principales</h3>
                    <div class="space-y-6">
                        @foreach($topSubjects as $subject)
                            <div class="group">
                                <div class="flex justify-between mb-2">
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.1em]">{{ $subject->subject }}</span>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">
                                        {{ floor($subject->total / 60) }}h {{ $subject->total % 60 }}m
                                    </span>
                                </div>
                                <div class="w-full bg-black/40 rounded-full h-2 border border-white/5">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-1000" 
                                         style="width: {{ $topSubjects->first() ? ($subject->total / $topSubjects->first()->total) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($topSubjects->isEmpty())
                            <p class="text-center text-slate-700 py-10 italic">Aucune donnée</p>
                        @endif
                    </div>
                </div>
                
                <!-- Assignments by Priority -->
                <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden">
                    <h3 class="text-2xl font-black text-white mb-8 tracking-tight">📋 Grille des Priorités</h3>
                    <div class="space-y-6">
                        @foreach($assignmentsByPriority as $item)
                            <a href="{{ route('assignments.index', ['priority' => $item->priority]) }}" class="flex items-center justify-between bg-black/40 p-5 rounded-[2rem] border border-white/5 hover:bg-black/60 transition-all cursor-pointer shadow-lg outline outline-1 outline-white/0 hover:outline-white/5 group mb-4 last:mb-0">
                                <div class="flex items-center">
                                    <div @class([
                                        'w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-105 transition-transform border border-white/5',
                                        'bg-red-500/10 text-red-500' => $item->priority === 'high',
                                        'bg-yellow-500/10 text-yellow-500' => $item->priority === 'medium',
                                        'bg-blue-500/10 text-blue-500' => $item->priority === 'low',
                                    ])>
                                        <span class="text-2xl font-black">
                                            {{ $item->count }}
                                        </span>
                                    </div>
                                    <div class="ml-5">
                                        <p class="text-sm font-bold text-white uppercase tracking-widest leading-none">
                                            @if($item->priority === 'high') Critique
                                            @elseif($item->priority === 'medium') Normal
                                            @else Faible
                                            @endif
                                        </p>
                                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-2">
                                            {{ $item->count }} Devoirs en attente
                                        </p>
                                    </div>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center border border-white/5 group-hover:bg-white/10 transition-colors">
                                    <svg class="w-4 h-4 text-slate-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        @endforeach
                        @if($assignmentsByPriority->isEmpty())
                            <p class="text-center text-slate-700 py-10 italic">Aucune priorité définie</p>
                        @endif
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</x-app-layout>
