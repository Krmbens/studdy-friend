<div class="space-y-10 animate-fade-in pb-20">
    <!-- Header Section -->
    <div class="px-4 sm:px-0">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">Minuteur Pomodoro</h2>
        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Optimisez votre concentration par sessions rythmées</p>
    </div>

    <div x-data="{ 
        timeLeft: 1500, 
        originalTime: 1500,
        timer: null, 
        isRunning: false, 
        mode: 'focus', 
        audio: new Audio('https://actions.google.com/sounds/v1/alarms/beep_short.ogg'),
        
        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        },
        
        get progress() {
            return ((this.originalTime - this.timeLeft) / this.originalTime) * 100;
        },

        startTimer() {
            if (this.isRunning) return;
            this.isRunning = true;
            this.timer = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                } else {
                    this.completeSession();
                }
            }, 1000);
        },
        
        pauseTimer() {
            this.isRunning = false;
            clearInterval(this.timer);
        },
        
        resetTimer() {
            this.pauseTimer();
            this.setMode(this.mode);
        },
        
        setMode(newMode) {
            this.mode = newMode;
            this.pauseTimer();
            if (newMode === 'focus') {
                this.originalTime = 25 * 60;
            } else if (newMode === 'short') {
                this.originalTime = 5 * 60;
            } else if (newMode === 'long') {
                this.originalTime = 15 * 60;
            }
            this.timeLeft = this.originalTime;
        },
        
        completeSession() {
            this.pauseTimer();
            this.audio.play();
            
            if (this.mode === 'focus') {
                @this.saveSession(this.originalTime);
                if (Notification.permission === 'granted') {
                    new Notification('Concentration Terminée', { body: 'Momentum atteint. Passez à la récupération.' });
                }
            } else {
                if (Notification.permission === 'granted') {
                    new Notification('Récupération Terminée', { body: 'Cerveau recalibré. Prêt pour un nouveau cycle ?' });
                }
            }
        },
        
        requestPermission() {
            if (Notification.permission !== 'granted') {
                Notification.requestPermission();
            }
        }
    }" 
    x-init="requestPermission()"
    class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
        
        <!-- Main Timer Module -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-12 text-center relative overflow-hidden shadow-2xl group">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>
                
                <!-- Mode Selection -->
                <div class="inline-flex items-center justify-center p-1.5 bg-black/40 rounded-2xl border border-white/5 mb-12 relative z-10">
                    <button @click="setMode('focus')" 
                        :class="mode === 'focus' ? 'bg-[#1a2333] text-white border-white/10 shadow-lg' : 'text-slate-500 hover:text-white'"
                        class="px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] transition-all border border-transparent">
                        Focus
                    </button>
                    <button @click="setMode('short')" 
                        :class="mode === 'short' ? 'bg-[#1a2333] text-emerald-400 border-white/10 shadow-lg' : 'text-slate-500 hover:text-white'"
                        class="px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] transition-all border border-transparent">
                        Courte Pause
                    </button>
                    <button @click="setMode('long')" 
                        :class="mode === 'long' ? 'bg-[#1a2333] text-blue-400 border-white/10 shadow-lg' : 'text-slate-500 hover:text-white'"
                        class="px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] transition-all border border-transparent">
                        Longue Pause
                    </button>
                </div>

                <!-- Circular Chronometer -->
                <div class="relative w-80 h-80 mx-auto flex items-center justify-center mb-12">
                    <svg class="w-full h-full transform -rotate-90 drop-shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                        <circle cx="160" cy="160" r="150" stroke="currentColor" stroke-width="10" fill="transparent" class="text-white/5" />
                        <circle cx="160" cy="160" r="150" stroke="currentColor" stroke-width="10" fill="transparent" 
                            :class="{
                                'text-blue-500': mode === 'focus',
                                'text-emerald-500': mode === 'short',
                                'text-indigo-500': mode === 'long'
                            }"
                            :stroke-dasharray="2 * Math.PI * 150" 
                            :stroke-dashoffset="2 * Math.PI * 150 * (1 - progress / 100)"
                            class="transition-all duration-1000 ease-linear" stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-8xl font-black tracking-tighter text-white drop-shadow-2xl" x-text="formatTime(timeLeft)">25:00</span>
                        <span class="text-[10px] font-bold text-slate-600 mt-4 uppercase tracking-[0.3em] bg-white/5 px-4 py-1.5 rounded-full border border-white/5" x-text="mode === 'focus' ? 'Session de Travail' : 'Période de Pause'">TRAVAIL</span>
                    </div>
                </div>

                <!-- Execution Controls -->
                <div class="flex justify-center items-center gap-6 relative z-10">
                    <template x-if="!isRunning">
                        <button @click="startTimer()" 
                            class="group flex items-center gap-4 px-10 py-5 bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-bold uppercase tracking-[0.3em] text-[11px] rounded-2xl shadow-2xl shadow-blue-500/20 hover:scale-105 active:scale-95 transition-all border border-white/10">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                            Démarrer
                        </button>
                    </template>
                    <template x-if="isRunning">
                        <button @click="pauseTimer()" 
                            class="group flex items-center gap-4 px-10 py-5 bg-[#1a2333] text-white font-bold uppercase tracking-[0.3em] text-[11px] rounded-2xl shadow-xl hover:scale-105 active:scale-95 transition-all border border-white/10">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1-1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            Suspendre
                        </button>
                    </template>
                    <button @click="resetTimer()" title="Réinitialiser" class="w-14 h-14 flex items-center justify-center text-slate-600 hover:text-white hover:bg-white/5 rounded-2xl transition-all border border-white/0 hover:border-white/5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Parameters -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl space-y-8">
                <h3 class="text-xl font-black text-white uppercase tracking-widest opacity-80">Paramètres de la Session</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Matière / Domaine</label>
                        <input type="text" wire:model="subject" class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" placeholder="ex: Physique Nucléaire">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Notes de Session</label>
                        <textarea wire:model="notes" rows="1" class="w-full bg-black/40 rounded-2xl border-white/5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all p-4 text-slate-300 font-bold" placeholder="Objectif principal..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="space-y-8">
            <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 p-10 rounded-[3rem] shadow-[0_20px_50px_rgba(59,130,246,0.3)] relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/20 rounded-full blur-3xl opacity-50 transition-transform duration-700 group-hover:scale-125"></div>
                <h3 class="text-white font-bold text-xs uppercase tracking-[0.2em] mb-8 opacity-80">PROGRÈS DU JOUR</h3>
                <div class="grid grid-cols-2 gap-6 relative z-10">
                    <div class="bg-white/10 rounded-2xl p-5 backdrop-blur-md border border-white/10 shadow-xl">
                        <div class="text-3xl font-black text-white leading-none">{{ $todaySessionsCount }}</div>
                        <div class="text-[9px] text-white/60 font-bold uppercase tracking-widest mt-2">Cycles</div>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-5 backdrop-blur-md border border-white/10 shadow-xl">
                        <div class="text-3xl font-black text-white leading-none">{{ $todayFocusMinutes }}</div>
                        <div class="text-[9px] text-white/60 font-bold uppercase tracking-widest mt-2">Minutes</div>
                    </div>
                </div>
                <div class="mt-8 bg-white/10 rounded-2xl p-6 backdrop-blur-md border border-white/10 shadow-xl flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="text-3xl">🔥</div>
                        <div>
                            <div class="text-2xl font-black text-white leading-none">{{ $streakValues }}</div>
                            <div class="text-[9px] text-white/60 font-bold uppercase tracking-widest mt-1">Série du jour</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Focus Optimization -->
            <div class="bg-[#0a0f1e] border border-white/5 rounded-[3rem] p-10 shadow-2xl group">
                <h3 class="text-white font-bold text-xs uppercase tracking-[0.15em] mb-8 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                    Conseils de Focus
                </h3>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-500 flex-shrink-0 mt-0.5 shadow-lg shadow-emerald-500/10">✓</div>
                        <span class="text-xs text-slate-500 font-medium leading-relaxed uppercase tracking-wider opacity-80">Focus unique. Évitez le multitâche.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-500 flex-shrink-0 mt-0.5 shadow-lg shadow-emerald-500/10">✓</div>
                        <span class="text-xs text-slate-500 font-medium leading-relaxed uppercase tracking-wider opacity-80">Repos visuel. Détachez-vous des écrans pendant les pauses.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-500 flex-shrink-0 mt-0.5 shadow-lg shadow-emerald-500/10">✓</div>
                        <span class="text-xs text-slate-500 font-medium leading-relaxed uppercase tracking-wider opacity-80">Hydratation. Maintenez vos niveaux de performance.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
