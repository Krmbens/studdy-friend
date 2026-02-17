<div class="space-y-10 animate-fade-in pb-20">
    <!-- Header Section -->
    <div class="px-4 sm:px-0">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">Résumé de Texte</h2>
        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Résumez vos cours et documents instantanément</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 px-4 sm:px-0">
        <!-- Input Protocol -->
        <div class="lg:col-span-5 space-y-8">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>
                
                <h3 class="text-white font-bold text-xs uppercase tracking-[0.2em] mb-10 opacity-80 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    Texte à résumer
                </h3>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contenu du document</label>
                        <textarea wire:model="textInput" rows="12" 
                                  class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold text-sm leading-relaxed"
                                  placeholder="Copiez votre texte ici... (Min. 50 caractères)"></textarea>
                        @error('textInput') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Style de résumé</label>
                        <select wire:model="style" 
                                class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                            <option value="key_points">Points clés essentiels</option>
                            <option value="concise">Résumé court</option>
                            <option value="elaborate">Résumé détaillé</option>
                        </select>
                    </div>

                    <button wire:click="summarize" 
                            wire:loading.attr="disabled"
                            class="w-full py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all border border-white/10 flex items-center justify-center gap-4 group">
                        <span wire:loading.remove>Générer le résumé</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Analyse en cours...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Synthesis Protocol -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl space-y-8">
                <h4 class="text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em] mb-6 opacity-40">Historique des résumés</h4>
                <div class="space-y-4">
                    @forelse($history ?? [] as $item)
                        <div wire:click="showSummary({{ $item->id }})" class="flex items-center gap-4 p-5 rounded-[2rem] bg-white/5 border border-white/0 hover:border-blue-500/30 transition-all cursor-pointer group">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 font-bold text-[10px] group-hover:bg-blue-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold text-white uppercase tracking-widest truncate">{{ Str::limit(strip_tags($item->summary_content), 30) }}</p>
                                <p class="text-[8px] text-slate-600 font-bold uppercase tracking-widest mt-1">{{ $item->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-20">
                            <p class="text-[8px] font-bold uppercase tracking-widest text-slate-500">Aucun historique</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Output Column -->
        <div class="lg:col-span-7">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] min-h-[600px] flex flex-col shadow-2xl relative overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-[0.2em]">Résultat du résumé</h3>
                        <p class="text-[9px] text-slate-600 font-bold uppercase tracking-[0.2em] mt-1">Contenu prêt à réviser</p>
                    </div>
                    @if($summary)
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            <span class="text-[9px] text-emerald-500/80 font-bold uppercase tracking-widest">Résumé Terminé</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 p-10 overflow-y-auto">
                    @if($summary)
                        <div class="prose prose-invert max-w-none animate-fade-in">
                            <div class="bg-black/40 border border-white/5 rounded-[2.5rem] p-10 leading-relaxed text-slate-400 font-medium text-sm">
                                <div class="markdown-body">
                                    {!! Str::markdown($summary) !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center opacity-20">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-white uppercase tracking-[0.2em]">Prêt à résumer</h4>
                            <p class="text-[10px] font-bold uppercase tracking-[0.3em] mt-2">Saisissez votre contenu pour commencer</p>
                        </div>
                    @endif
                </div>

                @if($summary)
                    <div class="p-8 border-t border-white/5 flex justify-end gap-4 bg-black/20">
                        <button wire:click="exportPdf" class="px-6 py-3 bg-blue-600 shadow-lg shadow-blue-600/20 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/10 transition-all flex items-center gap-3 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Exporter PDF
                        </button>
                        <button class="px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-[10px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
                            Copier le résumé
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Archive Modal -->
    @if($selectedSummary)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4 sm:p-6" x-data="{ show: true }" x-show="show" x-on:keydown.escape.window="$wire.closeModal()">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <!-- Modal Content -->
            <div class="relative w-full max-w-lg bg-[#0c0c0d] border border-white/10 rounded-[3rem] shadow-2xl overflow-hidden" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5 pointer-events-none"></div>
                
                <!-- Modal Header -->
                <div class="relative p-8 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-[0.2em] bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">Archive</span>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">{{ $selectedSummary->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-[0.2em]">Détails du résumé</h3>
                    </div>
                    <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all border border-white/5 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="relative p-8 max-h-[60vh] overflow-y-auto font-tajawal">
                    <div class="prose prose-invert max-w-none">
                        <div class="bg-black/30 border border-white/5 rounded-[2.5rem] p-8 leading-[1.8] text-slate-400 font-medium text-sm shadow-inner selection:bg-blue-500/30">
                            {!! Str::markdown($selectedSummary->summary_content) !!}
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="relative p-6 border-t border-white/5 bg-black/20 flex items-center justify-between gap-4">
                    <button wire:click="exportHistoryPdf({{ $selectedSummary->id }})" class="px-6 py-3 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
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
</div>
