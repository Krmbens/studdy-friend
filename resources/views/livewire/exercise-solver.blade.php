<div class="space-y-10 pb-20">
    <!-- Header Protocol -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">
                Résolveur d'Exercices
            </h2>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                L'IA est prête à vous aider
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Left: Input Sphere -->
        <div class="lg:col-span-5 space-y-8">
            <section class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-600/5 rounded-full blur-[100px] group-hover:bg-blue-600/10 transition-all duration-1000"></div>
                
                <h3 class="text-white font-bold text-xs uppercase tracking-[0.4em] mb-10 opacity-50 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    Détails de l'exercice
                </h3>

                <form wire:submit.prevent="solve" class="space-y-8">
                    <div class="space-y-3 font-cairo">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] px-1">Matière</label>
                        <select wire:model="subject" 
                                class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold appearance-none">
                            <option value="Mathématiques">Mathématiques</option>
                            <option value="Physique">Physique</option>
                            <option value="Informatique">Informatique</option>
                            <option value="Chimie">Chimie</option>
                            <option value="Biologie">Biologie</option>
                            <option value="Philosophie">Philosophie</option>
                        </select>
                        @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] px-1">Niveau de détail</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['Standard', 'Détaillé', 'Expert'] as $level)
                                <button type="button" 
                                        wire:click="$set('difficulty', '{{ $level }}')"
                                        class="py-3 px-4 rounded-xl border text-[10px] font-bold uppercase tracking-widest transition-all {{ $difficulty === $level ? 'bg-blue-500/10 border-blue-500/30 text-blue-400 shadow-lg' : 'bg-black/40 border-white/5 text-slate-600 hover:border-white/10' }}">
                                    {{ $level }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] px-1">Énoncé de l'exercice</label>
                        <textarea wire:model="problem" rows="8" 
                                  class="w-full bg-black/40 rounded-[2rem] border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-6 text-slate-300 font-medium leading-relaxed placeholder:text-slate-800"
                                  placeholder="Saisissez l'énoncé de votre exercice ici..."></textarea>
                        @error('problem') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full py-6 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.4em] text-xs shadow-2xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-1 active:scale-95 transition-all border border-white/10 flex items-center justify-center gap-4 group">
                        <span wire:loading.remove>Résoudre l'exercice</span>
                        <span wire:loading class="flex items-center gap-3">
                            <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            Analyse en cours...
                        </span>
                    </button>
                </form>
            </section>

            <!-- Status Meta -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[2.5rem] p-8 flex items-center justify-between opacity-50 group hover:opacity-100 transition-opacity">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 border border-white/5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Calculs sécurisés</span>
                </div>
                <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
            </div>
        </div>

        <!-- Right: Resolution Output -->
        <div class="lg:col-span-7 space-y-8">
            <section class="bg-[#0a0f1e] border border-white/5 rounded-[3.5rem] min-h-[700px] flex flex-col shadow-2xl relative overflow-hidden">
                <div class="p-10 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-[0.3em]">Solution détaillée</h3>
                        <p class="text-[9px] text-slate-600 font-bold uppercase tracking-[0.2em] mt-2">Générée en temps réel</p>
                    </div>
                </div>

                <div class="flex-1 p-10 relative">
                    @if($solution)
                        <div class="animate-fade-in space-y-8">
                            <div class="prose prose-invert max-w-none">
                                <div class="bg-black/30 border border-white/5 rounded-[2.5rem] p-10 leading-[1.8] text-slate-400 font-medium text-sm shadow-inner selection:bg-blue-500/30">
                                    {!! Str::markdown($solution) !!}
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-4 pt-4">
                                <button wire:click="exportPdf" class="px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-white text-[10px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-4 group">
                                    <svg class="w-4 h-4 text-emerald-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Exporter en PDF
                                </button>
                                <button class="px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-white text-[10px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-4 group">
                                    <svg class="w-4 h-4 text-blue-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                    Copier la solution
                                </button>
                            </div>
                        </div>
                    @elseif($isSolving)
                        <div class="h-full flex flex-col items-center justify-center text-center">
                            <div class="relative mb-10">
                                <div class="w-32 h-32 rounded-full border border-blue-500/20 border-t-blue-500 animate-spin"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 rounded-full border border-indigo-500/20 border-t-indigo-500 animate-spin-slow"></div>
                                </div>
                            </div>
                            <h4 class="text-xl font-bold text-white uppercase tracking-[0.3em] animate-pulse">Analyse en cours</h4>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.4em] mt-4">L'IA prépare votre réponse...</p>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center opacity-10 grayscale">
                            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-10 border border-white/5">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="text-2xl font-black text-white uppercase tracking-[0.3em]">En attente</h4>
                            <p class="text-[10px] font-bold uppercase tracking-[0.4em] mt-4">Saisissez votre exercice pour obtenir la solution</p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- History Protocol -->
            @if($recentSolutions && $recentSolutions->count() > 0)
                <section class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl">
                    <h3 class="text-slate-500 font-bold text-xs uppercase tracking-[0.4em] mb-10 opacity-50">Historique local</h3>
                    <div class="space-y-4">
                        @foreach($recentSolutions as $item)
                            <div wire:click="showSolution({{ $item->id }})" 
                                 class="group flex items-center justify-between p-6 bg-black/40 rounded-[2rem] border border-white/0 hover:border-blue-500/20 transition-all shadow-inner cursor-pointer">
                                <div class="flex items-center gap-6 min-w-0">
                                    <div class="w-12 h-12 rounded-xl bg-blue-500/5 flex items-center justify-center text-blue-500/50 group-hover:text-blue-400 group-hover:bg-blue-500/10 transition-all border border-white/5 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-white leading-tight uppercase tracking-widest truncate">{{ $item->subject }}</p>
                                        <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest truncate mt-1.5">{{ Str::limit($item->problem_statement, 50) }}</p>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold text-slate-800 uppercase tracking-tighter whitespace-nowrap ml-4">{{ $item->created_at->format('d M') }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    <!-- Solution Archive Modal -->
    @if($selectedSolution)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4 sm:p-6" x-data="{ show: true }" x-show="show" x-on:keydown.escape.window="$wire.closeModal()">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-lg bg-[#0c0c0d] border border-white/10 rounded-[3rem] shadow-2xl overflow-hidden" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5 pointer-events-none"></div>
                
                <!-- Modal Header -->
                <div class="relative p-8 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-[0.2em] bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">Archive</span>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">{{ $selectedSolution->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-[0.2em]">{{ $selectedSolution->subject }}</h3>
                    </div>
                    <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all border border-white/5 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="relative p-8 max-h-[60vh] overflow-y-auto font-cairo">
                    <div class="space-y-8">
                        <div>
                            <h4 class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em] mb-4">Énoncé initial</h4>
                            <div class="bg-black/40 border border-white/5 rounded-2xl p-6 text-sm text-slate-400 font-medium italic border-l-4 border-l-blue-500/50">
                                "{{ $selectedSolution->problem_statement }}"
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em] mb-6">Solution détaillée</h4>
                            <div class="prose prose-invert max-w-none">
                                <div class="bg-black/30 border border-white/5 rounded-[2.5rem] p-10 leading-[1.8] text-slate-400 font-medium text-sm shadow-inner selection:bg-blue-500/30">
                                    {!! Str::markdown($selectedSolution->solution_content) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="relative p-6 border-t border-white/5 bg-black/20 flex items-center justify-between gap-4">
                    <button wire:click="exportHistoryPdf({{ $selectedSolution->id }})" class="px-6 py-3 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF
                    </button>
                    <button wire:click="closeModal" class="px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl text-white text-[9px] font-bold uppercase tracking-[0.2em] transition-all">
                        Fermer x
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</div>
