<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Générateur de Quiz') }}
        </h2>
    </x-slot>

    <div class="space-y-10 animate-fade-in pb-20">
    <!-- Header Section -->
    <div class="px-4 sm:px-0">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">Générateur de Quiz</h2>
        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Évaluez vos connaissances de manière interactive</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 px-4 sm:px-0">
        <!-- Configuration Module -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>
                
                <h3 class="text-white font-bold text-xs uppercase tracking-[0.2em] mb-10 opacity-80 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    Configuration
                </h3>

                <form wire:submit.prevent="generate" class="space-y-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Matière / Domaine</label>
                        <select wire:model="subject" 
                                class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                            <option value="">Choisir...</option>
                            <option value="Mathématiques">Mathématiques</option>
                            <option value="Physique">Physique</option>
                            <option value="Informatique">Informatique</option>
                            <option value="Français">Français</option>
                            <option value="Anglais">Anglais</option>
                        </select>
                        @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contenu source (Optionnel)</label>
                        <textarea wire:model="sourceText" rows="4" 
                                  class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold text-xs"
                                  placeholder="Copiez vos notes ici pour générer un quiz personnalisé..."></textarea>
                        @error('sourceText') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre de Questions</label>
                        <input type="number" wire:model="count" min="1" max="20"
                               class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold"
                               placeholder="ex: 5">
                        @error('count') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Niveau de Difficulté</label>
                        <select wire:model="difficulty" 
                                class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                            <option value="Facile">Facile</option>
                            <option value="Moyen">Moyen</option>
                            <option value="Difficile">Difficile</option>
                        </select>
                    </div>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all border border-white/10 flex items-center justify-center gap-4 group">
                        <span wire:loading.remove>Générer le Quiz</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Préparation en cours...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Historical Archives -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl space-y-8">
                <h3 class="text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em]">Quiz Récents</h3>
                <div class="space-y-4">
                    @forelse($history ?? [] as $item)
                        <div wire:click="showQuiz({{ $item->id }})" class="p-5 rounded-2xl bg-black/20 border border-white/5 hover:border-blue-500/30 transition-all cursor-pointer group">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-white uppercase tracking-wider group-hover:text-blue-400 transition-colors">{{ $item->subject }}</span>
                                <span class="text-[9px] font-bold text-slate-600 uppercase">{{ $item->created_at->format('d M') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-20">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Aucun historique</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Assessment Matrix -->
        <div class="lg:col-span-8">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] min-h-[650px] flex flex-col shadow-2xl relative overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-[0.2em]">Espace Quiz</h3>
                        <p class="text-[9px] text-slate-600 font-bold uppercase tracking-[0.2em] mt-1">Interface interactive</p>
                    </div>
                    @if($showResults)
                        <div class="flex items-center gap-6">
                            <button wire:click="exportPdf" class="px-5 py-2.5 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Exporter PDF
                            </button>
                            <div class="flex items-center gap-3">
                                <span class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">Score:</span>
                                <div class="w-32 bg-black/40 h-2 rounded-full border border-white/5">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full shadow-[0_0_10px_rgba(59,130,246,0.3)]" style="width:{{ $score }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-white">{{ round($score) }}%</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex-1 p-10 overflow-y-auto">
                    @if($questions)
                        @if(!$showResults)
                            <div class="space-y-12 animate-fade-in">
                                @foreach($questions as $index => $q)
                                    <div class="space-y-6">
                                        <div class="flex gap-6">
                                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-500 font-bold text-xs shrink-0 border border-blue-500/10 shadow-lg">
                                                {{ $index + 1 }}
                                            </div>
                                            <h4 class="text-lg font-bold text-white tracking-tight leading-relaxed">{{ $q['question'] }}</h4>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-16">
                                            @foreach((is_array($q['options']) ? $q['options'] : []) as $optionIndex => $option)
                                                <button wire:click="selectAnswer({{ $index }}, {{ $optionIndex }})"
                                                        @class([
                                                            'w-full p-5 rounded-2xl border text-left text-sm font-bold transition-all active:scale-[0.98]',
                                                            'bg-blue-600/20 border-blue-500/50 text-white shadow-xl shadow-blue-500/10' => ($userAnswers[$index] ?? null) === $optionIndex,
                                                            'bg-black/40 border-white/5 text-slate-400 hover:border-blue-500/20 hover:text-slate-200' => ($userAnswers[$index] ?? null) !== $optionIndex,
                                                        ])>
                                                    {{ $option }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="h-[1px] bg-white/5 w-full my-10"></div>
                                @endforeach

                                <div class="mt-12 flex justify-center pb-10">
                                    <button wire:click="submitQuiz"
                                            class="px-12 py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.05] transition-all border border-white/10 disabled:opacity-50"
                                            {{ count($userAnswers) < count($questions) ? 'disabled' : '' }}>
                                        Valider mes réponses
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Results Visualization -->
                            <div class="space-y-12 animate-fade-in pb-10">
                                <div class="bg-black/20 rounded-[2.5rem] p-10 border border-white/5 text-center space-y-4">
                                    <h4 class="text-4xl font-black text-white tracking-tighter">{{ round($score) }}%</h4>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Résultat final obtenu</p>
                                    <button wire:click="resetQuiz" class="mt-6 px-8 py-4 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/10 transition-all">
                                        Réessayer
                                    </button>
                                </div>

                                <div class="space-y-8">
                                    @foreach($questions as $index => $q)
                                        <div class="p-8 rounded-[2rem] bg-black/40 border border-white/5 relative overflow-hidden">
                                            @php 
                                                $userOption = $q['options'][$userAnswers[$index]] ?? null;
                                                $isCorrect = $userOption === $q['correct_answer'];
                                            @endphp
                                            
                                            <div class="flex items-start gap-6 relative z-10">
                                                <div @class([
                                                    'w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 border shadow-lg',
                                                    'bg-green-500/20 text-green-500 border-green-500/10' => $isCorrect,
                                                    'bg-red-500/20 text-red-500 border-red-500/10' => !$isCorrect,
                                                ])>
                                                    {{ $index + 1 }}
                                                </div>
                                                <div class="space-y-4">
                                                    <h5 class="text-white font-bold text-sm leading-relaxed">{{ $q['question'] }}</h5>
                                                    <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest">
                                                        <span class="text-slate-500">Votre réponse:</span>
                                                        <span @class(['text-red-400' => !$isCorrect, 'text-green-400' => $isCorrect])>{{ $userOption ?? 'N/A' }}</span>
                                                        @if(!$isCorrect)
                                                            <span class="text-slate-500 ml-4">Bonne réponse:</span>
                                                            <span class="text-green-400">{{ $q['correct_answer'] }}</span>
                                                        @endif
                                                    </div>
                                                    @if($q['explanation'])
                                                        <div class="p-4 rounded-xl bg-blue-500/5 border border-blue-500/10">
                                                            <p class="text-[10px] text-blue-300 font-medium leading-relaxed italic">
                                                                <span class="font-bold uppercase tracking-widest mr-2 opacity-50">Explication:</span>
                                                                {{ $q['explanation'] }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- No Active Assessment -->
                        <div class="flex-1 flex flex-col items-center justify-center opacity-20 space-y-6">
                            <div class="w-20 h-20 rounded-[2rem] border-2 border-dashed border-slate-600 flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            </div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500">En attente de configuration</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Archive Modal -->
    @if($selectedQuiz)
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
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">{{ $selectedQuiz->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-[0.2em]">{{ $selectedQuiz->subject }}</h3>
                    </div>
                    <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all border border-white/5 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="relative p-8 max-h-[60vh] overflow-y-auto font-tajawal">
                    <div class="space-y-8">
                        @foreach($selectedQuiz->questions as $index => $q)
                            <div class="p-8 rounded-[2rem] bg-black/40 border border-white/5 relative overflow-hidden">
                                <div class="flex items-start gap-6 relative z-10">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-500 border border-blue-500/10 flex items-center justify-center font-bold text-xs shrink-0 shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="space-y-4">
                                        <h5 class="text-white font-bold text-sm leading-relaxed">{{ $q->question_text }}</h5>
                                        <div class="space-y-2">
                                            @foreach($q->options as $option)
                                                <div @class([
                                                    'p-3 rounded-xl border text-xs font-medium',
                                                    'bg-green-500/20 border-green-500/10 text-green-400' => $option === $q->correct_answer,
                                                    'bg-black/20 border-white/5 text-slate-500' => $option !== $q->correct_answer,
                                                ])>
                                                    {{ $option }}
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($q->explanation)
                                            <div class="p-4 rounded-xl bg-blue-500/5 border border-blue-500/10">
                                                <p class="text-[10px] text-blue-300 font-medium leading-relaxed italic">
                                                    <span class="font-bold uppercase tracking-widest mr-2 opacity-50">Explication:</span>
                                                    {{ $q->explanation }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="relative p-6 border-t border-white/5 bg-black/20 flex items-center justify-between gap-4">
                    <button wire:click="exportHistoryPdf({{ $selectedQuiz->id }})" class="px-6 py-3 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
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
