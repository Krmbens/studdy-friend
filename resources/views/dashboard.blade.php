<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">
                {{ __('Espace Études') }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-10 pb-20">
        <!-- Dashboard Greeting Banner -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#0a0f1e] to-[#020617] border border-white/5 rounded-[3.5rem] p-12 shadow-2xl group">
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-600/5 rounded-full blur-[100px] group-hover:bg-blue-600/10 transition-all duration-1000"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-400/5 rounded-full blur-[80px]"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-10">
                <div class="max-w-3xl">
                    @php
                        $hour = date('H');
                        if ($hour < 12) $greeting = "Bonjour";
                        elseif ($hour < 18) $greeting = "Bon après-midi";
                        else $greeting = "Bonne soirée";
                    @endphp
                    <h3 class="text-blue-500 font-bold text-xs uppercase tracking-[0.4em] mb-4 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        {{ $greeting }}
                    </h3>
                    <h2 class="text-5xl font-black text-white tracking-tighter leading-none mb-6">
                        Ravi de vous revoir, <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-400">{{ Auth::user()->name }}</span>.
                    </h2>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest leading-relaxed max-w-xl opacity-80">
                        Continuez votre progression. Vous avez maintenu une série de <span class="text-white">{{ $currentStreak }} jours</span> d'étude consécutifs.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div class="bg-black/40 backdrop-blur-xl border border-white/5 p-6 rounded-[2rem] flex items-center gap-6 shadow-xl">
                        <div class="w-14 h-14 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-2xl shadow-inner border border-white/5">🔥</div>
                        <div>
                            <p class="text-2xl font-black text-white leading-none">{{ $currentStreak }}</p>
                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Jours de suite</p>
                        </div>
        </section>
        
        <!-- Overview Statistics Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('assignments.index') }}" class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300 block">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-all"></div>
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-2xl border border-white/5 shadow-lg">📚</div>
                    <div>
                        <p class="text-3xl font-black text-white leading-none">{{ $totalAssignmentsCount }}</p>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Total Devoirs</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('assignments.index', ['filter' => 'progress']) }}" class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300 block">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-500 text-2xl border border-white/5 shadow-lg">⏳</div>
                    <div>
                        <p class="text-3xl font-black text-white leading-none">{{ $inProgressAssignmentsCount }}</p>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">En Cours</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('assignments.index', ['filter' => 'completed']) }}" class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300 block">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"></div>
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 text-2xl border border-white/5 shadow-lg">✅</div>
                    <div>
                        <p class="text-3xl font-black text-white leading-none">{{ $completedAssignmentsCount }}</p>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Complétés</p>
                    </div>
                </div>
            </a>

            <div class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-all"></div>
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 text-2xl border border-white/5 shadow-lg">📅</div>
                    <div>
                        <p class="text-3xl font-black text-white leading-none">{{ $sessionsThisWeekCount }}</p>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Sessions d'Étude (Semaine)</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Actions Rapides -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('study-sessions.index') }}" class="group bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] hover:bg-slate-900 transition-all duration-500 shadow-xl flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform shadow-lg border border-white/5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">Session d'Étude</span>
            </a>
            <a href="{{ route('quiz.index') }}" class="group bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] hover:bg-slate-900 transition-all duration-500 shadow-xl flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform shadow-lg border border-white/5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">Nouveau Quiz</span>
            </a>
            <a href="{{ route('summarizer.index') }}" class="group bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] hover:bg-slate-900 transition-all duration-500 shadow-xl flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform shadow-lg border border-white/5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">Résumer</span>
            </a>
            <a href="{{ route('exercise-solver.index') }}" class="group bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] hover:bg-slate-900 transition-all duration-500 shadow-xl flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 group-hover:scale-110 transition-transform shadow-lg border border-white/5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">Résoudre</span>
            </a>
        </section>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
            <!-- Left Column: Intelligence Feed & Performance -->
            <div class="xl:col-span-8 space-y-10">
                
                <!-- Performance Matrix (Chart) -->
                <section class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] p-12 relative overflow-hidden group shadow-2xl">
                    <div class="flex items-center justify-between mb-12">
                        <div>
                            <h3 class="text-2xl font-black text-white mb-2 tracking-tight">Temps d'Étude</h3>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em]">Performance sur les 7 derniers jours (minutes)</p>
                        </div>
                    </div>

                    <div class="relative h-64 w-full">
                        @php
                            $maxStudy = max(array_merge($dailyStudyTime, [1]));
                            $points = "";
                            $widthPerPoint = 1000 / 6;
                            foreach($dailyStudyTime as $i => $min) {
                                $x = $i * $widthPerPoint;
                                $y = 180 - ($min / $maxStudy * 150);
                                $points .= ($i == 0 ? "M" : " L") . "$x,$y";
                            }
                            $areaPoints = $points . " L1000,200 L0,200 Z";
                        @endphp
                        <svg viewBox="0 0 1000 200" class="w-full h-full drop-shadow-[0_20px_50px_rgba(59,130,246,0.15)] overflow-visible">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.4" />
                                    <stop offset="100%" stop-color="#3b82f6" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path d="{{ $areaPoints }}" fill="url(#chartGradient)"></path>
                            <path d="{{ $points }}" stroke="#3b82f6" stroke-width="6" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
                            @foreach($dailyStudyTime as $i => $min)
                                @php
                                    $x = $i * $widthPerPoint;
                                    $y = 180 - ($min / $maxStudy * 150);
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="white" stroke="#3b82f6" stroke-width="3" />
                            @endforeach
                        </svg>
                        
                        <div class="flex justify-between mt-8 px-2">
                            @foreach($labels as $label)
                                <span class="text-[9px] uppercase font-bold text-slate-700 tracking-[0.3em]">{{ $label }}</span>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Latest Activity Feed -->
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-white tracking-tight">Activités Récentes</h3>
                        <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">Flux en temps réel</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($intelligenceFeed as $item)
                            <div class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] group hover:bg-slate-900 transition-all duration-500 shadow-xl relative overflow-hidden">
                                <div class="flex items-center gap-5 mb-6">
                                    @if($item['type'] === 'tip')
                                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 border border-white/5">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white uppercase tracking-widest">Conseil</p>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $item['date']->diffForHumans() }}</p>
                                        </div>
                                    @elseif($item['type'] === 'quiz')
                                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-white/5">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white uppercase tracking-widest">Évaluation Quiz</p>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $item['date']->diffForHumans() }}</p>
                                        </div>
                                    @elseif($item['type'] === 'summary')
                                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-white/5">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white uppercase tracking-widest">Résumé</p>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $item['date']->diffForHumans() }}</p>
                                        </div>
                                    @elseif($item['type'] === 'solution')
                                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 border border-white/5">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white uppercase tracking-widest">Exercice Résolu</p>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $item['date']->diffForHumans() }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-4">
                                    <h4 class="text-white font-black text-lg tracking-tight leading-tight group-hover:text-blue-400 transition-colors">
                                        @if($item['type'] === 'tip') {{ $item['data']->subject }}
                                        @elseif($item['type'] === 'quiz') {{ $item['data']->title ?: $item['data']->subject }}
                                        @elseif($item['type'] === 'summary') {{ Str::limit(strip_tags($item['data']->original_content), 40) }}
                                        @elseif($item['type'] === 'solution') {{ $item['data']->subject }}
                                        @endif
                                    </h4>
                                    <p class="text-slate-500 text-[10px] font-bold leading-relaxed uppercase tracking-widest line-clamp-2">
                                        @if($item['type'] === 'tip') {{ Str::limit($item['data']->tip_content, 100) }}
                                        @elseif($item['type'] === 'quiz') {{ $item['data']->questions->count() }} questions générées.
                                        @elseif($item['type'] === 'summary') {{ Str::limit($item['data']->summary_content, 100) }}
                                        @elseif($item['type'] === 'solution') {{ Str::limit($item['data']->problem_statement, 100) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center border-2 border-dashed border-white/5 rounded-[3rem] opacity-30">
                                <p class="text-[10px] font-bold uppercase tracking-widest">Aucune activité récente</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column: Devoirs & Stats -->
            <div class="xl:col-span-4 space-y-10">
                
                <!-- Prochaines échéances -->
                <section class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] p-10 shadow-2xl">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-2xl font-black text-white tracking-tight">Prochaines échéances</h3>
                        <a href="{{ route('assignments.index') }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white transition-all border border-white/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    
                    <div class="space-y-6">
                        @forelse($upcomingAssignments as $assignment)
                            <div class="group relative bg-black/40 border border-white/0 hover:border-white/5 rounded-[2rem] p-6 transition-all shadow-inner hover:shadow-2xl">
                                <div class="flex items-center gap-5 mb-5">
                                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 font-bold text-xs border border-white/5">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-white leading-tight truncate tracking-tight">{{ $assignment->title }}</p>
                                        <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest truncate mt-1">{{ $assignment->subject }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest">
                                    <span class="text-blue-500">{{ $assignment->deadline->diffForHumans() }}</span>
                                    <span class="text-slate-700">Priorité: {{ $assignment->priority ?: 'Basse' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center opacity-20">
                                <p class="text-[10px] font-bold uppercase tracking-widest">Tout est à jour</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- Statistiques -->
                <section class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] p-10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/5 rounded-full blur-2xl"></div>
                    <h3 class="text-2xl font-black text-white mb-10 tracking-tight">Statistiques</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-6 bg-black/40 rounded-[2rem] border border-white/5 group-hover:border-blue-500/30 transition-all shadow-inner">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 border border-white/5 shadow-lg">🏆</div>
                                <div>
                                    <p class="text-base font-black text-white leading-none">{{ $completedThisWeek }}</p>
                                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Terminés</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-black/40 rounded-[2rem] border border-white/5 group-hover:border-indigo-500/30 transition-all shadow-inner">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-white/5 shadow-lg">🧠</div>
                                <div>
                                    <p class="text-base font-black text-white leading-none">{{ $focusSubject }}</p>
                                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-2">Matière Principale</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Meta -->
                    <div class="mt-8 pt-8 border-t border-white/5">
                        <div class="flex items-center justify-between opacity-50">
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Système Prêt</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
