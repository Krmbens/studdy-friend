<div class="space-y-10 animate-fade-in pb-20">
    <!-- Header Section -->
    <div class="px-4 sm:px-0">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">Générateur de Flashcards</h2>
        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Mémorisez plus efficacement avec des flashcards interactives</p>
    </div>

    <div class="max-w-[1520px] mx-auto px-4 sm:px-0">
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl opacity-50"></div>
            
            @if(!$isReviewing && !$deckComplete)
                <!-- Generator Protocol -->
                <div class="max-w-xl mx-auto space-y-12">
                    <div class="text-center">
                        <h3 class="text-2xl font-black text-white uppercase tracking-widest">Créer un paquet</h3>
                        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-2">Transformez vos cours en fiches de révision</p>
                    </div>

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Sujet / Matière</label>
                            <input type="text" wire:model="topic" 
                                   class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" 
                                   placeholder="ex: Biologie Cellulaire">
                            @error('topic') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contenu source</label>
                            <textarea wire:model="sourceText" rows="6" 
                                      class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold leading-relaxed" 
                                      placeholder="Copiez vos notes de cours ici..."></textarea>
                            @error('sourceText') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre de fiches</label>
                            <select wire:model="numCards" 
                                    class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                <option value="5">5 fiches de révision</option>
                                <option value="10">10 fiches de révision</option>
                                <option value="15">15 fiches de révision</option>
                            </select>
                        </div>

                        <button wire:click="generateCards" 
                                wire:loading.attr="disabled" 
                                class="w-full py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all border border-white/10 flex items-center justify-center gap-4 group">
                            <span wire:loading.remove>Créer les flashcards</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Création en cours...
                            </span>
                        </button>
                    </div>
                </div>

            @elseif($isReviewing)
                <!-- Recall Interface -->
                <div class="max-w-2xl mx-auto space-y-12 animate-fade-in">
                    <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-500">
                                {{ $reviewIndex + 1 }}
                            </div>
                            <span>Carte {{ $reviewIndex + 1 }} sur {{ $currentDeck->cards->count() }}</span>
                        </div>
                        <span class="text-white">{{ $currentDeck->name }}</span>
                    </div>

                    <!-- Card Flip Container -->
                    <div class="perspective-1000 w-full h-[500px] cursor-pointer group" wire:click="flip">
                        <div class="relative w-full h-full transition-all duration-700 transform-style-3d shadow-2xl rounded-[3rem] {{ $isFlipped ? 'rotate-y-180' : '' }}">
                            
                            <!-- Front -->
                            <div class="absolute inset-0 w-full h-full bg-[#1a1a1c] border border-white/5 rounded-[3rem] p-12 flex flex-col items-center justify-center backface-hidden shadow-2xl">
                                <div class="absolute top-10 left-10 flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Question</span>
                                </div>
                                <h4 class="text-3xl font-black text-white text-center leading-tight tracking-tight px-10">{{ $currentDeck->cards[$reviewIndex]->front_content }}</h4>
                                <div class="absolute bottom-10 text-[9px] font-bold text-slate-600 uppercase tracking-[0.3em] flex items-center gap-3">
                                    <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    Cliquez pour voir la réponse
                                </div>
                            </div>

                            <!-- Back -->
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-blue-900/40 to-indigo-900/40 border border-blue-500/20 rounded-[3rem] p-12 flex flex-col items-center justify-center backface-hidden rotate-y-180 shadow-2xl backdrop-blur-xl">
                                <div class="absolute top-10 left-10 flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-[9px] font-bold text-white/50 uppercase tracking-widest">Réponse</span>
                                </div>
                                <p class="text-xl font-bold text-white text-center leading-relaxed px-10">{{ $currentDeck->cards[$reviewIndex]->back_content }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <div class="flex justify-center items-center gap-8">
                        <button wire:click="prevCard" 
                                class="w-16 h-16 flex items-center justify-center bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-2xl transition-all border border-white/5 hover:border-white/10 disabled:opacity-20" 
                                {{ $reviewIndex === 0 ? 'disabled' : '' }}>
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button wire:click="nextCard" 
                                class="px-12 py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.05] active:scale-95 transition-all border border-white/10">
                            {{ $reviewIndex < $currentDeck->cards->count() - 1 ? 'Suivant' : 'Terminer la révision' }}
                        </button>
                    </div>
                </div>
            
            @elseif($deckComplete)
                <!-- Convergence Session -->
                <div class="text-center py-20 space-y-10 animate-fade-in">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-2xl ring-4 ring-emerald-500/20">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-white uppercase tracking-tighter">Révision terminée !</h2>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-3">Vous avez révisé {{ $currentDeck->cards->count() }} fiches de connaissance</p>
                    </div>
                    
                    <div class="flex justify-center gap-6">
                        <button wire:click="exportPdf" class="px-8 py-4 bg-blue-600 shadow-lg shadow-blue-600/20 text-white rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] transition-all border border-white/10 flex items-center gap-3 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Exporter PDF
                        </button>
                        <button wire:click="startReview" class="px-8 py-4 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] transition-all">
                            Recommencer
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 transition-all border border-white/10">
                            Accueil
                        </a>
                    </div>
                </div>

            @endif
        </div>

        <!-- Neural Archives: Flashcard Decks -->
        @if($history->count() > 0)
            <div class="mt-12 space-y-8 px-4 sm:px-0">
                <h3 class="text-white font-bold text-[10px] uppercase tracking-[0.3em] opacity-40">Mes paquets de fiches</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($history as $deck)
                        <div wire:click="showDeck({{ $deck->id }})" class="p-8 rounded-[2.5rem] bg-[#0a0f1e] border border-white/5 hover:border-blue-500/20 transition-all relative group overflow-hidden cursor-pointer shadow-xl">
                            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-600/5 rounded-full blur-2xl group-hover:bg-blue-600/10 transition-all duration-700"></div>
                            
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <span class="text-[9px] font-bold text-slate-700 uppercase">{{ $deck->created_at->format('d M') }}</span>
                            </div>

                            <h5 class="text-sm font-black text-white uppercase tracking-wider mb-2 truncate">{{ $deck->name }}</h5>
                            <div class="flex items-center gap-3">
                                <span class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">{{ $deck->cards_count }} Fiches</span>
                                <div class="w-1 h-1 rounded-full bg-slate-800"></div>
                                <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">Enregistré</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Deck Archive Modal -->
    @if($selectedDeck)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4 sm:p-6" x-data="{ show: true }" x-show="show" x-on:keydown.escape.window="$wire.closeModal()">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <!-- Modal Content -->
            <div class="relative w-full max-w-lg bg-[#0c0c0d] border border-white/10 rounded-[3rem] shadow-2xl overflow-hidden flex flex-col max-h-[85vh]" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5 pointer-events-none"></div>
                
                <!-- Modal Header -->
                <div class="relative p-8 border-b border-white/5 flex items-center justify-between bg-black/20 shrink-0">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-[0.2em] bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">Archive</span>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">{{ $selectedDeck->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-[0.2em]">{{ $selectedDeck->name }}</h3>
                    </div>
                    <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all border border-white/5 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="relative p-8 overflow-y-auto flex-1 font-tajawal">
                    <div class="space-y-6">
                        @foreach($selectedDeck->cards as $card)
                            <div class="p-8 rounded-[2rem] bg-black/40 border border-white/5 space-y-4">
                                <div class="flex items-start gap-4">
                                    <span class="text-[9px] font-bold text-blue-500 uppercase tracking-[0.3em] mt-1 shrink-0">Question:</span>
                                    <p class="text-sm font-bold text-white leading-relaxed">{{ $card->front_content }}</p>
                                </div>
                                <div class="h-[1px] bg-white/5 w-12 ml-14"></div>
                                <div class="flex items-start gap-4">
                                    <span class="text-[9px] font-bold text-indigo-500 uppercase tracking-[0.3em] mt-1 shrink-0">Réponse:</span>
                                    <p class="text-sm font-medium text-slate-400 leading-relaxed italic">{{ $card->back_content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="relative p-6 border-t border-white/5 bg-black/20 flex items-center justify-between gap-4 shrink-0">
                    <button wire:click="exportHistoryPdf({{ $selectedDeck->id }})" class="px-6 py-3 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
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
        .perspective-1000 { perspective: 2000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
    </style>
</div>
