<div class="space-y-8 animate-fade-in">
    
    <!-- message de succès -->
    @if (session()->has('message'))
        <div class="animate-slide-in bg-blue-500/10 border border-blue-500/20 text-blue-400 p-6 rounded-[2rem] shadow-2xl mb-8 flex items-center gap-4" role="alert">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <p class="font-bold uppercase tracking-widest text-xs">{{ session('message') }}</p>
        </div>
    @endif
    
    <!-- Bouton d'ajout -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Liste des Devoirs</h3>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Gérez vos objectifs académiques</p>
        </div>
        <button wire:click="toggleForm" 
                class="group relative inline-flex items-center justify-center px-8 py-4 font-bold uppercase tracking-widest text-xs transition-all duration-300 active:scale-95 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40">
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 transition-all duration-300 group-hover:scale-[1.02]"></div>
            <span class="relative flex items-center gap-2 text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Nouveau Devoir
            </span>
        </button>
    </div>
    
    <!-- Modal Formulaire -->
    @if($showForm)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black/80 transition-opacity" aria-hidden="true" wire:click="toggleForm"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-[#0a0f1e] rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/10">
                
                <!-- Header -->
                <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/5">
                    <h3 class="text-xl font-black text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
                        {{ $editingId ? 'Modifier le Devoir' : 'Nouveau Jalon Académique' }}
                    </h3>
                    <button wire:click="toggleForm" class="text-gray-400 hover:text-white transition-colors bg-white/5 p-2 rounded-xl hover:bg-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-8 py-8">
                    <form wire:submit.prevent="save" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Titre du Devoir</label>
                                <input type="text" wire:model="title" 
                                       class="w-full bg-black/40 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white placeholder-slate-700 text-sm font-bold"
                                       placeholder="ex: Recherche en Physique Quantique">
                                @error('title') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Matière / Domaine</label>
                                <select wire:model="subject" 
                                        class="w-full bg-black/40 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white font-bold text-sm appearance-none">
                                    <option value="" class="bg-[#0a0f1e]">Choisir un domaine...</option>
                                    <option value="Mathématiques" class="bg-[#0a0f1e]">Mathématiques</option>
                                    <option value="Physique" class="bg-[#0a0f1e]">Physique</option>
                                    <option value="Informatique" class="bg-[#0a0f1e]">Informatique</option>
                                    <option value="Français" class="bg-[#0a0f1e]">Français / Littérature</option>
                                    <option value="Anglais" class="bg-[#0a0f1e]">Langues</option>
                                    <option value="Autre" class="bg-[#0a0f1e]">Autre Domaine</option>
                                </select>
                                @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Date d'Échéance</label>
                                <input type="date" wire:model="deadline" 
                                       class="w-full bg-black/40 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white font-bold text-sm">
                                @error('deadline') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Niveau de Priorité</label>
                                <select wire:model="priority" 
                                        class="w-full bg-black/40 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white font-bold text-sm appearance-none">
                                    <option value="low" class="bg-[#0a0f1e]">Faible</option>
                                    <option value="medium" class="bg-[#0a0f1e]">Normale</option>
                                    <option value="high" class="bg-[#0a0f1e]">Critique</option>
                                </select>
                                @error('priority') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-2 space-y-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Description / Notes</label>
                                <textarea wire:model="description" rows="4"
                                          class="w-full bg-black/40 border border-white/5 rounded-[2rem] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-6 text-white text-sm font-medium leading-relaxed"
                                          placeholder="Décrivez les objectifs principaux..."></textarea>
                            </div>
                            
                        </div>
                        
                        <div class="pt-6 flex justify-end gap-4 border-t border-white/5 mt-8">
                             <button type="button" wire:click="toggleForm"
                                    class="text-slate-400 hover:text-white px-8 py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-colors hover:bg-white/5">
                                Annuler
                            </button>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white px-10 py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50">
                                <span wire:loading.remove wire:target="save">
                                    {{ $editingId ? 'Mettre à jour' : 'Enregistrer' }}
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full border-2 border-white/30 border-t-white animate-spin"></div>
                                    Synchronisation...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Recherche et Filtres -->
    <div class="bg-[#0a0f1e] border border-white/5 p-8 rounded-[2.5rem] shadow-2xl mb-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Recherche -->
            <div class="relative group">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" 
                       wire:model.live="search"
                       placeholder="Filtrer par titre..."
                       class="w-full pl-12 bg-black/40 border-white/5 rounded-2xl focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white text-xs font-bold placeholder-slate-700">
            </div>

            <!-- Matière -->
            <div class="relative">
                <select wire:model.live="filterSubject"
                        class="w-full bg-black/40 border-white/5 rounded-2xl focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white text-xs font-bold appearance-none">
                    <option value="" class="bg-[#0a0f1e]">Toutes les Matières</option>
                    @php
                        $subjects = ['Mathématiques', 'Physique', 'Informatique', 'Français', 'Anglais', 'Autre'];
                    @endphp
                    @foreach($subjects as $subj)
                        <option value="{{ $subj }}" class="bg-[#0a0f1e]">{{ $subj }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Priorité -->
            <div class="relative">
                <select wire:model.live="filterPriority"
                        class="w-full bg-black/40 border-white/5 rounded-2xl focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white text-xs font-bold appearance-none">
                    <option value="" class="bg-[#0a0f1e]">Toutes les Priorités</option>
                    <option value="low" class="bg-[#0a0f1e]">Priorité Faible</option>
                    <option value="medium" class="bg-[#0a0f1e]">Priorité Normale</option>
                    <option value="high" class="bg-[#0a0f1e]">Priorité Critique</option>
                </select>
            </div>
            
            <!-- État -->
            <div class="relative">
                <select wire:model.live="filterCompleted"
                        class="w-full bg-black/40 border-white/5 rounded-2xl focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all p-4 text-white text-xs font-bold appearance-none">
                    <option value="" class="bg-[#0a0f1e]">Tous les États</option>
                    <option value="0" class="bg-[#0a0f1e]">En Cours</option>
                    <option value="1" class="bg-[#0a0f1e]">Terminés</option>
                </select>
            </div>
            
        </div>
        
        @if($search || $filterPriority || $filterCompleted !== '' || $filterSubject)
            <div class="mt-6 flex justify-start">
                <button wire:click="$set('search', ''); $set('filterPriority', ''); $set('filterCompleted', ''); $set('filterSubject', '');"
                        class="text-[9px] font-bold text-blue-400 opacity-60 hover:opacity-100 transition-all flex items-center gap-2 uppercase tracking-widest px-4 py-2 bg-white/5 rounded-xl border border-white/5">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Effacer les filtres
                </button>
            </div>
        @endif
    </div>

    <!-- Liste des Devoirs (Tableau) -->
    <div class="bg-[#0a0f1e] border border-white/5 rounded-[2.5rem] shadow-2xl overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-black/20">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Titre</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Matière</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Échéance</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Priorité</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Statut</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($assignments as $assignment)
                        <tr @class([
                            'group hover:bg-white/5 transition-colors',
                            'opacity-40 grayscale' => $assignment->completed
                        ])>
                            <td class="px-8 py-6">
                                <p @class([
                                    'text-sm font-bold text-white tracking-tight leading-none',
                                    'line-through text-slate-500' => $assignment->completed
                                ])>{{ $assignment->title }}</p>
                                @if($assignment->description)
                                    <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-2 truncate max-w-xs">{{ Str::limit($assignment->description, 50) }}</p>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-[9px] font-bold uppercase tracking-widest border border-blue-500/20">
                                    {{ $assignment->subject }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <svg @class([
                                        'w-4 h-4',
                                        'text-red-500' => $assignment->deadline < now() && !$assignment->completed,
                                        'text-slate-600' => !($assignment->deadline < now() && !$assignment->completed)
                                    ]) fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span @class([
                                        'text-xs font-bold tracking-tight',
                                        'text-red-500' => $assignment->deadline < now() && !$assignment->completed,
                                        'text-slate-400' => !($assignment->deadline < now() && !$assignment->completed)
                                    ])>
                                        {{ $assignment->deadline->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span @class([
                                        'w-2 h-2 rounded-full',
                                        'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' => $assignment->priority === 'high',
                                        'bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.6)]' => $assignment->priority === 'medium',
                                        'bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]' => $assignment->priority === 'low',
                                    ])></span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $assignment->priority }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <button wire:click="toggleComplete({{ $assignment->id }})" 
                                        @class([
                                            'px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all border',
                                            'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' => $assignment->completed,
                                            'bg-blue-600/10 text-blue-400 border-blue-500/20 hover:bg-blue-600/20' => !$assignment->completed,
                                        ])>
                                    {{ $assignment->completed ? 'Terminé' : 'En Cours' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="viewDetails({{ $assignment->id }})" class="p-2 hover:bg-white/5 rounded-lg text-purple-400 transition-colors" title="Voir détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="edit({{ $assignment->id }})"
                                            class="p-2.5 bg-white/5 text-slate-500 hover:text-white rounded-xl transition-all border border-white/0 hover:border-white/5 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="delete({{ $assignment->id }})"
                                            onclick="return confirm('Souhaitez-vous vraiment supprimer ce devoir ?')"
                                            class="p-2.5 bg-white/5 text-slate-500 hover:text-red-400 rounded-xl transition-all border border-white/0 hover:border-red-400/10 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <div class="w-20 h-20 bg-black/40 shadow-2xl rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-white/5">
                                    <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-white mb-2 tracking-tight">Aucun devoir à afficher</h3>
                                <p class="text-slate-600 text-[10px] font-bold uppercase tracking-widest max-w-xs mx-auto mb-8">Ajustez vos filtres ou créez votre premier objectif académique.</p>
                                <button wire:click="toggleForm" class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white px-8 py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl shadow-blue-500/20 transition-all active:scale-95">Ajouter un devoir</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal Détails -->
    @if($viewingAssignment)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black/80 transition-opacity" aria-hidden="true" wire:click="closeDetails"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-[#0f172a] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/10">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/5">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <span class="p-2 rounded-lg bg-blue-500/20 text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </span>
                        {{ $viewingAssignment->title }}
                    </h3>
                    <button wire:click="closeDetails" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 py-6 space-y-6">
                    <!-- Meta Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Matière</div>
                            <div class="font-semibold text-blue-400">{{ $viewingAssignment->subject }}</div>
                        </div>
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Date limite</div>
                            <div class="font-semibold {{ \Carbon\Carbon::parse($viewingAssignment->deadline)->isPast() && !$viewingAssignment->completed ? 'text-red-400' : 'text-white' }}">
                                {{ \Carbon\Carbon::parse($viewingAssignment->deadline)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Priorité</div>
                            <div class="font-semibold
                                @if($viewingAssignment->priority == 'high') text-red-400
                                @elseif($viewingAssignment->priority == 'medium') text-yellow-400
                                @else text-green-400 @endif">
                                {{ ucfirst($viewingAssignment->priority) }}
                            </div>
                        </div>
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Statut</div>
                            <div class="font-semibold {{ $viewingAssignment->completed ? 'text-green-400' : 'text-gray-400' }}">
                                {{ $viewingAssignment->completed ? 'Terminé' : 'En cours' }}
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5 min-h-[100px]">
                        <div class="text-xs text-gray-400 mb-2 uppercase tracking-wider font-bold">Description</div>
                        <div class="text-gray-300 whitespace-pre-wrap leading-relaxed">
                            {{ $viewingAssignment->description ?: 'Aucune description fournie.' }}
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-black/20 border-t border-white/5 flex flex-wrap gap-3 justify-end">
                    <button wire:click="delete({{ $viewingAssignment->id }}); closeDetails()" 
                            class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Supprimer
                    </button>
                    
                    <button wire:click="edit({{ $viewingAssignment->id }}); closeDetails()" 
                            class="px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Modifier
                    </button>

                    <button wire:click="toggleComplete({{ $viewingAssignment->id }})" 
                            class="px-4 py-2 {{ $viewingAssignment->completed ? 'bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-500' : 'bg-green-500/10 hover:bg-green-500/20 text-green-400' }} rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                        @if($viewingAssignment->completed)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Marquer en cours
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Marquer terminé
                        @endif
                    </button>

                    <button wire:click="downloadPdf({{ $viewingAssignment->id }})" 
                            class="px-4 py-2 bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 rounded-lg transition-colors text-sm font-medium flex items-center gap-2 border border-purple-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Exporter PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
