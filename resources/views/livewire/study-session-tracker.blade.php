<div class="space-y-10 animate-fade-in pb-20">
    
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="animate-slide-in bg-blue-500/10 border border-blue-500/20 text-blue-400 p-6 rounded-[2rem] shadow-2xl flex items-center justify-between" role="alert">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="font-bold uppercase tracking-widest text-xs">{{ session('message') }}</p>
            </div>
            <button @click="open = false" class="text-slate-500 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
    
    <!-- Filters and Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Filter: Subject -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[2rem] p-6 shadow-xl">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Filtrer par Matière</label>
            <select wire:model.live="filterSubject" class="w-full bg-black/40 rounded-xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-3 text-slate-300 font-bold text-sm">
                <option value="">Toutes les matières</option>
                <option value="Mathématiques">Mathématiques</option>
                <option value="Physique">Physique</option>
                <option value="Informatique">Tech / Info</option>
                <option value="Français">Lettres</option>
                <option value="Anglais">Langues</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <!-- Filter: Period -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[2rem] p-6 shadow-xl">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Filtrer par Période</label>
            <select wire:model.live="filterPeriod" class="w-full bg-black/40 rounded-xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-3 text-slate-300 font-bold text-sm">
                <option value="all">Toutes les périodes</option>
                <option value="today">Aujourd'hui</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
            </select>
        </div>

        <!-- Stat: Total Hours -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all"></div>
            <div class="relative z-10">
                <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Total Heures</h3>
                <p class="text-4xl font-black text-white tracking-tighter">
                    {{ floor($totalHours / 60) }}<span class="text-xl opacity-30 ml-1">h</span> {{ $totalHours % 60 }}<span class="text-xl opacity-30 ml-1">m</span>
                </p>
            </div>
        </div>

        <!-- Stat: Daily Average -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-600/10 rounded-full blur-2xl group-hover:bg-indigo-600/20 transition-all"></div>
            <div class="relative z-10">
                <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Moyenne par Jour</h3>
                <p class="text-4xl font-black text-white tracking-tighter">
                    {{ floor($dailyAverage / 60) }}<span class="text-xl opacity-30 ml-1">h</span> {{ round($dailyAverage % 60) }}<span class="text-xl opacity-30 ml-1">m</span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Aujourd'hui -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 relative overflow-hidden group shadow-2xl">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-700"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600/20 flex items-center justify-center text-blue-500 border border-blue-500/10 shadow-xl group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-xs uppercase tracking-[0.2em] opacity-50">Aujourd'hui</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Performance de Focus</p>
                    </div>
                </div>
                <p class="text-7xl font-black text-white tracking-tighter drop-shadow-2xl">
                    {{ floor($totalToday / 60) }}<span class="text-3xl opacity-30 ml-1">h</span> {{ $totalToday % 60 }}<span class="text-3xl opacity-30 ml-1">m</span>
                </p>
            </div>
        </div>
        
        <!-- Semaine -->
        <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 relative overflow-hidden group shadow-2xl">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-indigo-600/10 rounded-full blur-3xl group-hover:bg-indigo-600/20 transition-all duration-700"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600/20 flex items-center justify-center text-indigo-500 border border-indigo-500/10 shadow-xl group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-xs uppercase tracking-[0.2em] opacity-50">Volume Hebdomadaire</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Progrès Cumulés</p>
                    </div>
                </div>
                <p class="text-7xl font-black text-white tracking-tighter drop-shadow-2xl">
                    {{ floor($totalThisWeek / 60) }}<span class="text-3xl opacity-30 ml-1">h</span> {{ $totalThisWeek % 60 }}<span class="text-3xl opacity-30 ml-1">m</span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Gestion des Sessions -->
    <div class="flex justify-between items-center bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-xl">
        <div>
            <h3 class="text-2xl font-black text-white tracking-[0.05em]">Journal des Sessions</h3>
            <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Historique complet de vos études</p>
        </div>
        <button wire:click="toggleForm" 
                @class([
                    'px-8 py-4 text-[10px] font-bold uppercase tracking-[0.2em] rounded-2xl transition-all shadow-xl active:scale-95',
                    'bg-white/10 text-white border border-white/10' => $showForm,
                    'bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-blue-500/20 border border-white/10' => !$showForm,
                ])>
            {{ $showForm ? 'Annuler' : 'Ajouter manuellement +' }}
        </button>
    </div>
    
    <!-- Formulaire d'entrée -->
    @if($showForm)
        <div class="bg-[#0a0f1e] border border-white/5 p-10 rounded-[3rem] animate-slide-in shadow-2xl relative overflow-hidden">
            <h4 class="text-xl font-black text-white mb-10 tracking-tight uppercase tracking-widest opacity-80">Enregistrer une Session</h4>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Matière / Domaine</label>
                        <select wire:model="subject" 
                                class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                            <option value="">Sélectionner...</option>
                            <option value="Mathématiques">Mathématiques</option>
                            <option value="Physique">Physique</option>
                            <option value="Informatique">Tech / Info</option>
                            <option value="Français">Lettres</option>
                            <option value="Anglais">Langues</option>
                            <option value="Autre">Autre</option>
                        </select>
                        @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Durée (Min)</label>
                        <div class="relative">
                            <input type="number" wire:model="durationMinutes" min="1" max="600"
                                   class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold pr-16"
                                   placeholder="45">
                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-600 text-[10px] font-bold uppercase">MIN</span>
                        </div>
                        @error('durationMinutes') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Date de Session</label>
                        <input type="date" wire:model="sessionDate" 
                               class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                        @error('sessionDate') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="md:col-span-3 space-y-3">
                        <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Notes (Optionnel)</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold"
                                  placeholder="Décrivez votre travail..."></textarea>
                    </div>
                    
                </div>
                
                <div class="mt-10 flex justify-end">
                    <button type="submit" 
                            class="px-10 py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.02] transition-all border border-white/10">
                        Enregistrer la Session
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    <!-- Sessions Table -->
    <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] shadow-2xl overflow-hidden">
        <div class="p-10">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h4 class="text-2xl font-black text-white tracking-[0.05em]">Liste des Sessions</h4>
                    <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Historique complet de vos études</p>
                </div>
                <button wire:click="toggleForm" 
                        @class([
                            'px-8 py-4 text-[10px] font-bold uppercase tracking-[0.2em] rounded-2xl transition-all shadow-xl active:scale-95',
                            'bg-white/10 text-white border border-white/10' => $showForm,
                            'bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-blue-500/20 border border-white/10' => !$showForm,
                        ])>
                    {{ $showForm ? 'Annuler' : 'Ajouter manuellement +' }}
                </button>
            </div>
            
            <!-- Form -->
            @if($showForm)
                <div class="bg-black/30 border border-white/5 p-10 rounded-[2rem] animate-slide-in mb-10">
                    <h4 class="text-xl font-black text-white mb-8 tracking-tight uppercase tracking-widest opacity-80">Enregistrer une Session</h4>
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Matière / Domaine</label>
                                <select wire:model="subject" class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                    <option value="">Sélectionner...</option>
                                    <option value="Mathématiques">Mathématiques</option>
                                    <option value="Physique">Physique</option>
                                    <option value="Informatique">Tech / Info</option>
                                    <option value="Français">Lettres</option>
                                    <option value="Anglais">Langues</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Durée (Min)</label>
                                <div class="relative">
                                    <input type="number" wire:model="durationMinutes" min="1" max="600"
                                           class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold pr-16"
                                           placeholder="45">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-600 text-[10px] font-bold uppercase">MIN</span>
                                </div>
                                @error('durationMinutes') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Date de Session</label>
                                <input type="date" wire:model="sessionDate" class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold">
                                @error('sessionDate') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-3 space-y-3">
                                <label class="block text-[10px] font-bold text-white uppercase tracking-[0.2em] opacity-50">Notes (Optionnel)</label>
                                <textarea wire:model="notes" rows="2"
                                          class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold"
                                          placeholder="Décrivez votre travail..."></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-10 py-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white font-bold uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-blue-500/20 hover:scale-[1.02] transition-all border border-white/10">
                                Enregistrer la Session
                            </button>
                        </div>
                    </form>
                </div>
            @endif
            
            <!-- Table -->
            @if($sessions && $sessions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="text-left py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Matière</th>
                                <th class="text-left py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Durée</th>
                                <th class="text-left py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Date</th>
                                <th class="text-left py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Notes</th>
                                <th class="text-right py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 border border-white/5">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <span class="font-bold text-white text-sm uppercase tracking-wide">{{ $session->subject }}</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6">
                                        <span class="text-slate-300 font-bold text-sm">{{ $session->duration_minutes }} min</span>
                                    </td>
                                    <td class="py-5 px-6">
                                        <span class="text-slate-400 text-xs font-bold">{{ \Carbon\Carbon::parse($session->session_date)->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                                    </td>
                                    <td class="py-5 px-6">
                                        @if($session->notes)
                                            <span class="text-slate-500 text-xs italic">{{ Str::limit($session->notes, 30) }}</span>
                                        @else
                                            <span class="text-slate-700 text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="viewSession({{ $session->id }})" class="w-10 h-10 flex items-center justify-center text-blue-500 hover:bg-blue-500/10 rounded-xl transition-all border border-transparent hover:border-blue-500/20" title="Voir détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <button wire:click="delete({{ $session->id }})" onclick="return confirm('Effacer cet enregistrement ?')" class="w-10 h-10 flex items-center justify-center text-slate-700 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all border border-transparent hover:border-red-500/20" title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-24 bg-black/20 rounded-[2rem] border border-white/5 border-dashed">
                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h5 class="text-xl font-black text-white mb-2 uppercase tracking-widest opacity-30">Aucune Session</h5>
                    <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em]">Commencez une session de travail pour la voir ici</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Details Modal -->
    @if($viewingSession)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <div class="inline-block align-bottom bg-[#0a0f1e] border border-white/10 rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="p-10">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-white tracking-tight uppercase">Détails de la Session</h3>
                        <button wire:click="closeModal" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/5 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-black/30 border border-white/5 p-6 rounded-2xl">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Matière</p>
                                    <p class="text-white font-bold text-lg">{{ $viewingSession->subject }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Durée</p>
                                    <p class="text-white font-bold text-lg">{{ floor($viewingSession->duration_minutes / 60) }}h {{ $viewingSession->duration_minutes % 60 }}m</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Date</p>
                                    <p class="text-white font-bold text-lg">{{ \Carbon\Carbon::parse($viewingSession->session_date)->locale('fr')->isoFormat('DD MMMM YYYY') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Enregistré</p>
                                    <p class="text-white font-bold text-lg">{{ $viewingSession->created_at->locale('fr')->isoFormat('DD MMM YYYY') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($viewingSession->notes)
                        <div class="bg-black/30 border border-white/5 p-6 rounded-2xl">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Notes</p>
                            <p class="text-slate-300 text-sm leading-relaxed italic">"{{ $viewingSession->notes }}"</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <button wire:click="closeModal" class="px-8 py-4 bg-white/5 text-white rounded-2xl font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-white/10 transition-all border border-white/10">
                            Fermer
                        </button>
                        <button wire:click="exportPdf({{ $viewingSession->id }})" class="px-8 py-4 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl font-bold uppercase tracking-[0.2em] text-[10px] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all border border-white/10">
                            📥 Télécharger PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
