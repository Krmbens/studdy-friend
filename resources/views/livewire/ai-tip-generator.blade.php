<div class="space-y-10 animate-fade-in pb-20">
    <!-- Messages -->
    @if (session()->has('message'))
        <div class="animate-slide-in bg-blue-500/10 border border-blue-500/20 text-blue-400 p-6 rounded-[2rem] shadow-2xl flex items-center justify-between" role="alert">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="font-bold uppercase tracking-widest text-xs">{{ session('message') }}</p>
            </div>
            <button wire:click="$set('message', null)" class="text-slate-500 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="animate-slide-in bg-red-500/10 border border-red-500/20 text-red-400 p-6 rounded-[2rem] shadow-2xl flex items-center justify-between" role="alert">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center text-red-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="font-bold uppercase tracking-widest text-xs">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Configuration Module -->
        <div class="lg:col-span-12">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-64 h-64 bg-blue-600/5 rounded-full blur-3xl group-hover:bg-blue-600/10 transition-all duration-1000"></div>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-10">
                    <div class="max-w-2xl">
                        <h3 class="text-white font-bold text-xs uppercase tracking-[0.3em] mb-4 flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            Assistant d'étude
                        </h3>
                        <h2 class="text-4xl font-black text-white tracking-tight leading-tight">Plan d'Études IA</h2>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mt-4">Un programme personnalisé pour optimiser vos révisions et réussir vos examens.</p>
                    </div>

                    <div class="flex items-center gap-4 bg-black/40 p-4 rounded-3xl border border-white/5">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest max-w-[200px]">Notre IA analyse vos besoins pour créer un calendrier de révision optimal.</p>
                    </div>
                </div>

                <div class="h-[1px] bg-white/5 w-full my-12"></div>

                <form wire:submit.prevent="generateEnhancedPlan" class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <!-- Basic Info Section -->
                        <div class="space-y-8">
                            <h4 class="text-white font-bold text-[10px] uppercase tracking-[0.2em] opacity-40 mb-6">Informations de Base</h4>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Matière / Domaine</label>
                                <select wire:model="subject" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                    <option value="">Choisir...</option>
                                    <option value="Mathématiques">Mathématiques</option>
                                    <option value="Physique">Physique</option>
                                    <option value="Informatique">Informatique</option>
                                    <option value="Français">Français</option>
                                    <option value="Anglais">Anglais</option>
                                    <option value="Chimie">Chimie</option>
                                    <option value="Biologie">Biologie</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Jours restants avant l'examen</label>
                                <input type="number" wire:model="daysUntilExam" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" placeholder="Optionnel">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Niveau d'études</label>
                                <select wire:model="academicLevel" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                    <option value="">Niveau...</option>
                                    <option value="Lycée">Lycée</option>
                                    <option value="Licence">Licence / Université</option>
                                    <option value="Master">Master / Doctorat</option>
                                    <option value="Professionnelle">Formation Pro</option>
                                </select>
                                @error('academicLevel') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Preferences Section -->
                        <div class="space-y-8">
                            <h4 class="text-white font-bold text-[10px] uppercase tracking-[0.2em] opacity-40 mb-6">Paramètres de révision</h4>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Style d'apprentissage</label>
                                <select wire:model="learningStyle" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                    <option value="">Style...</option>
                                    <option value="Visuel">Visuel (schémas, vidéos)</option>
                                    <option value="Auditif">Auditif (lecture à voix haute)</option>
                                    <option value="Lecture/Écriture">Lecture / Écriture (notes)</option>
                                    <option value="Kinesthésique">Kinesthésique (pratique)</option>
                                </select>
                                @error('learningStyle') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Temps disponible (Heures/Jour)</label>
                                <input type="number" wire:model="availableHoursPerDay" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" min="1" max="12">
                                @error('availableHoursPerDay') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Niveau de compréhension</label>
                                <select wire:model="understandingLevel" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                    <option value="">Niveau...</option>
                                    <option value="Débutant">Débutant / Découverte</option>
                                    <option value="Basique">Notions de base</option>
                                    <option value="Intermédiaire">Maîtrise correcte</option>
                                    <option value="Avancé">Niveau avancé</option>
                                </select>
                                @error('understandingLevel') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Specifics Section -->
                        <div class="space-y-8">
                            <h4 class="text-white font-bold text-[10px] uppercase tracking-[0.2em] opacity-40 mb-6">Détails spécifiques</h4>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Sujets difficiles</label>
                                <textarea wire:model="difficultTopics" rows="3" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold text-xs" placeholder="Ce qui vous pose problème..."></textarea>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Objectifs visés</label>
                                <input type="text" wire:model="specificGoals" class="w-full bg-black/60 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" placeholder="ex: Réussir l'examen final">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center pt-8">
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="px-16 py-6 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] text-white font-bold uppercase tracking-[0.4em] text-xs shadow-2xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all border border-white/10 flex items-center justify-center gap-6 group">
                            <span wire:loading.remove class="flex items-center gap-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Générer mon plan d'études
                            </span>
                            <span wire:loading class="flex items-center gap-4">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Calcul du plan optimal...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Result Matrix -->
        @if($generatedPlan)
            <div class="lg:col-span-12">
                <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] shadow-2xl overflow-hidden animate-slide-up">
                    <div class="p-8 border-b border-white/5 flex items-center justify-between bg-black/20">
                        <div>
                            <h3 class="text-white font-bold text-sm uppercase tracking-[0.2em]">Votre Plan d'Études</h3>
                            <p class="text-[9px] text-slate-600 font-bold uppercase tracking-[0.2em] mt-1">Généré avec succès</p>
                        </div>
                        <button wire:click="resetForm" class="p-3 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-xl transition-all border border-white/0 hover:border-white/10 active:scale-90">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-10">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                            <div class="lg:col-span-1 space-y-6">
                                <div class="bg-black/40 p-6 rounded-3xl border border-white/5">
                                    <h4 class="text-[9px] font-bold text-slate-600 uppercase tracking-widest mb-4">Informations d'Analyse</h4>
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-[10px] font-bold text-slate-500 uppercase">Sujet:</span>
                                            <span class="text-[10px] font-bold text-white uppercase">{{ $subject }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-[10px] font-bold text-slate-500 uppercase">Style:</span>
                                            <span class="text-[10px] font-bold text-blue-400 uppercase tracking-tighter">{{ $learningStyle }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-[10px] font-bold text-slate-500 uppercase">Intensité:</span>
                                            <span class="text-[10px] font-bold text-white capitalize">{{ $availableHoursPerDay }}h / Jour</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-blue-600/10 p-6 rounded-3xl border border-blue-500/10">
                                    <p class="text-[9px] font-bold text-blue-400 uppercase leading-relaxed font-tajawal">
                                        Nous avons adapté les méthodes de révision à votre profil d'apprentissage.
                                    </p>
                                </div>
                            </div>

                            <div class="lg:col-span-3">
                                <div class="prose prose-invert max-w-none">
                                    <div class="bg-black/20 rounded-[2.5rem] p-10 border border-white/5 font-medium text-slate-300 leading-relaxed text-sm shadow-inner whitespace-pre-wrap">
                                        {!! $generatedPlan !!}
                                    </div>
                                </div>
                                <div class="mt-8 flex gap-4">
                                    <button wire:click="exportPdf" class="px-8 py-4 bg-blue-600 shadow-lg shadow-blue-600/20 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/10 transition-all flex items-center gap-3 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Exporter PDF
                                    </button>
                                    <button class="px-8 py-4 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/10 transition-all flex items-center gap-3 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                        Sauvegarder
                                    </button>
                                    <button wire:click="generateEnhancedPlan" class="px-8 py-4 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/10 transition-all flex items-center gap-3 active:scale-95 text-blue-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Régénérer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Archives History -->
        @if($recentPlans->count() > 0)
            <div class="lg:col-span-12">
                <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl">
                    <h3 class="text-white font-bold text-[10px] uppercase tracking-[0.3em] opacity-40 mb-10">Mes plans d'études</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentPlans as $plan)
                            <div class="p-8 rounded-[2rem] bg-black/20 border border-white/5 hover:border-blue-500/20 transition-all relative group overflow-hidden h-[180px] flex flex-col justify-between">
                                <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-600/5 rounded-full blur-2xl group-hover:bg-blue-600/10 transition-all duration-700"></div>
                                
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <h5 class="text-xs font-bold text-white uppercase tracking-wider">{{ $plan->subject }}</h5>
                                        <span class="text-[9px] font-bold text-slate-600 uppercase">{{ $plan->created_at->format('d M') }}</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest line-clamp-3 leading-loose opacity-60">
                                        {{ Str::limit(strip_tags($plan->tip_content), 120) }}
                                    </p>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <button wire:click="showPlan({{ $plan->id }})" class="text-[9px] font-bold text-blue-500 uppercase tracking-widest hover:text-blue-400 transition-colors">Afficher</button>
                                    <button wire:click="deletePlan({{ $plan->id }})" onclick="return confirm('Supprimer ce plan d\'études ?')" class="text-slate-700 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Study Plan Archive Modal -->
    @if($selectedPlan)
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
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">{{ $selectedPlan->created_at->format('d M, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-[0.2em]">{{ $selectedPlan->subject }}</h3>
                    </div>
                    <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all border border-white/5 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="relative p-8 max-h-[60vh] overflow-y-auto font-tajawal">
                    <div class="space-y-8">
                        <div>
                            <h4 class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em] mb-4">Plan détaillé</h4>
                            <div class="prose prose-invert max-w-none">
                                <div class="bg-black/30 border border-white/5 rounded-[2.5rem] p-8 leading-[1.8] text-slate-400 font-medium text-sm shadow-inner selection:bg-blue-500/30 whitespace-pre-wrap">
                                    {!! $selectedPlan->tip_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="relative p-6 border-t border-white/5 bg-black/20 flex items-center justify-between gap-4">
                    <button wire:click="exportHistoryPdf({{ $selectedPlan->id }})" class="px-6 py-3 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 rounded-xl text-blue-400 text-[9px] font-bold uppercase tracking-[0.2em] transition-all flex items-center gap-3">
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