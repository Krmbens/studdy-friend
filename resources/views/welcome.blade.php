<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Studdy-Freind | Votre Allié d'Études avec l'IA</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;400;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; scroll-behavior: smooth; }
            .glow-mesh {
                background: 
                    radial-gradient(at 0% 0%, hsla(215, 60%, 10%, 1) 0, transparent 50%), 
                    radial-gradient(at 50% 100%, hsla(220, 50%, 20%, 1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(210, 40%, 15%, 1) 0, transparent 50%);
            }
            .glass {
                background: rgba(255, 255, 255, 0.02);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .reveal {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }
            .stagger-1 { transition-delay: 0.1s; }
            .stagger-2 { transition-delay: 0.2s; }
            .stagger-3 { transition-delay: 0.3s; }
        </style>
    </head>
    <body class="bg-[#020617] text-slate-200 overflow-x-hidden selection:bg-blue-500/30">
        <div class="fixed inset-0 glow-mesh z-0 opacity-60"></div>
        
        <div class="relative z-10 flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav class="p-8 flex justify-between items-center max-w-7xl mx-auto w-full">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <span class="font-black text-xs text-white">SF</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-white">Studdy-Freind</span>
                </div>
                <div class="flex items-center gap-8">
                    <div class="hidden md:flex items-center gap-8 mr-8">
                        <a href="#mission" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">Notre Mission</a>
                        <a href="#logiciel" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">Fonctionnement</a>
                        <a href="#outils" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">Nos Outils</a>
                    </div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[10px] font-bold uppercase tracking-wider text-blue-400 hover:text-white transition-colors">Espace Étudiant</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">Se connecter</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 rounded-full text-[10px] font-bold uppercase tracking-wider text-white transition-all shadow-lg shadow-blue-500/20">S'inscrire</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="min-h-[85vh] flex flex-col items-center justify-center px-6 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-blue-500/20 bg-blue-500/5 mb-8 reveal">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-400">Plateforme d'aide aux études par l'IA</span>
                </div>

                <h1 class="text-5xl md:text-8xl font-black tracking-tight leading-[0.9] mb-8 max-w-5xl reveal stagger-1">
                    Réussissez vos études avec <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Intelligence Artificielle.</span>
                </h1>

                <p class="text-slate-400 max-w-2xl text-lg md:text-xl font-medium leading-relaxed mb-12 reveal stagger-2">
                    Une interface simple et puissante conçue pour les étudiants. 
                    Gagnez du temps en résolvant vos exercices et en résumant vos cours instantanément.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 items-center reveal stagger-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-10 py-5 bg-blue-600 hover:bg-blue-500 rounded-2xl shadow-xl shadow-blue-500/20 transition-all transform hover:scale-105 text-[11px] font-bold uppercase tracking-wider text-white flex items-center gap-3">
                            Aller au Tableau de Bord
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-slate-900 hover:bg-slate-100 rounded-2xl transition-all transform hover:scale-105 text-[11px] font-bold uppercase tracking-wider flex items-center gap-3">
                            Commencer gratuitement
                        </a>
                        <a href="{{ route('login') }}" class="px-10 py-5 glass hover:bg-white/5 rounded-2xl transition-all text-[11px] font-bold uppercase tracking-wider text-white">
                            Déjà membre
                        </a>
                    @endauth
                </div>
            </section>

            <!-- Mission Section -->
            <section id="mission" class="py-32 px-6 flex flex-col items-center justify-center text-center bg-slate-900/50 backdrop-blur-xl border-y border-white/5">
                <div class="max-w-4xl reveal">
                    <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500 mb-8">Notre Mission</h2>
                    <blockquote class="text-3xl md:text-5xl font-bold leading-tight text-white mb-12">
                        "Simplifier l'apprentissage pour chaque étudiant en rendant l'intelligence artificielle accessible, utile et facile à utiliser au quotidien."
                    </blockquote>
                    <p class="text-slate-500 text-sm max-w-2xl mx-auto leading-relaxed">
                        Studdy-Freind est né de la volonté d'aider les étudiants à surmonter les difficultés académiques grâce à des outils intuitifs. Nous transformons vos documents complexes en connaissances claires.
                    </p>
                </div>
            </section>

            <!-- Fonctionnement -->
            <section id="logiciel" class="py-32 px-6 max-w-7xl mx-auto w-full">
                <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-center text-slate-500 mb-20 reveal">Comment ça marche ?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 relative">
                    @php
                        $steps = [
                            ['step' => '01', 'title' => 'Envoyez vos cours', 'desc' => 'Téléchargez vos PDF, photos d\'exercices ou copiez vos notes de cours.'],
                            ['step' => '02', 'title' => 'Analyse par l\'IA', 'desc' => 'Notre système analyse le contenu et identifie les points essentiels ou les solutions.'],
                            ['step' => '03', 'title' => 'Recevez l\'aide', 'desc' => 'Obtenez des explications étape par étape, des résumés clairs ou des quiz d\'entraînement.']
                        ];
                    @endphp

                    @foreach($steps as $s)
                        <div class="flex flex-col items-center text-center reveal stagger-{{ $loop->iteration }}">
                            <div class="w-20 h-20 rounded-2xl bg-slate-800/50 border border-blue-500/10 flex items-center justify-center text-blue-400 mb-8 shadow-inner group hover:border-blue-500/30 transition-colors">
                                <span class="text-xl font-bold">{{ $s['step'] }}</span>
                            </div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-white mb-4">{{ $s['title'] }}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed max-w-[250px]">{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Detailed Outils -->
            <section id="outils" class="py-32 px-6 bg-blue-600/5">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center mb-32 reveal">
                        <div class="space-y-8">
                            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">Nos Outils</h2>
                            <h3 class="text-4xl md:text-6xl font-black uppercase leading-tight text-white leading-none">Résolveur <span class="text-slate-500">d'Exercices.</span></h3>
                            <p class="text-slate-400 text-lg leading-relaxed">
                                Un assistant puissant capable de décomposer les problèmes scientifiques et mathématiques complexes. Obtenez non seulement la réponse, mais aussi le raisonnement.
                            </p>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 text-sm font-medium text-slate-300">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Explications détaillées étape par étape
                                </li>
                                <li class="flex items-center gap-3 text-sm font-medium text-slate-300">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Support multi-matières (Maths, Physique, etc.)
                                </li>
                            </ul>
                        </div>
                        <div class="glass h-[350px] rounded-[2.5rem] border border-white/5 flex items-center justify-center p-12">
                           <div class="w-full h-full bg-blue-500/5 rounded-2xl animate-pulse"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center flex-row-reverse reveal">
                        <div class="lg:order-2 space-y-8">
                            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-indigo-500">Synthèse Rapide</h2>
                            <h3 class="text-4xl md:text-6xl font-black uppercase leading-tight text-white leading-none">Résumeur <span class="text-slate-500">de Documents.</span></h3>
                            <p class="text-slate-400 text-lg leading-relaxed">
                                Gagnez des heures de lecture en transformant de longs documents en résumés concis. Idéal pour réviser rapidement l'essentiel d'un chapitre.
                            </p>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 text-sm font-medium text-slate-300">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div> Extraction des concepts clés
                                </li>
                                <li class="flex items-center gap-3 text-sm font-medium text-slate-300">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div> Organisation structurée des archives
                                </li>
                            </ul>
                        </div>
                        <div class="glass h-[350px] rounded-[2.5rem] border border-white/5 flex items-center justify-center p-12 lg:order-1">
                            <div class="w-full h-full bg-indigo-500/5 rounded-2xl animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="py-32 px-6">
                <div class="max-w-7xl mx-auto glass rounded-[3rem] p-12 md:p-16 border border-white/5 text-center">
                    <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 mb-12">L'impact de Studdy-Freind</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                        <div class="reveal stagger-1">
                            <div class="text-4xl md:text-5xl font-black mb-2 text-white">1.2M</div>
                            <div class="text-[9px] font-bold uppercase tracking-widest text-blue-400">Exercices Résolus</div>
                        </div>
                        <div class="reveal stagger-2">
                            <div class="text-4xl md:text-5xl font-black mb-2 text-white">50K+</div>
                            <div class="text-[9px] font-bold uppercase tracking-widest text-indigo-400">Résumés de Cours</div>
                        </div>
                        <div class="reveal stagger-3">
                            <div class="text-4xl md:text-5xl font-black mb-2 text-white">98.4%</div>
                            <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Taux de Précision</div>
                        </div>
                        <div class="reveal stagger-4">
                            <div class="text-4xl md:text-5xl font-black mb-2 text-white">24/7</div>
                            <div class="text-[9px] font-bold uppercase tracking-widest text-slate-500">Disponibilité</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="p-12 md:p-24 border-t border-white/5 bg-slate-950/50">
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                    <div class="col-span-1 md:col-span-1 border-slate-800">
                        <div class="flex items-center gap-2 mb-8">
                            <div class="w-6 h-6 rounded bg-blue-600 flex items-center justify-center">
                                <span class="font-black text-[10px] text-white">SF</span>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white">Studdy-Freind</span>
                        </div>
                        <p class="text-slate-500 text-[11px] leading-relaxed">
                            La plateforme moderne pour accompagner les étudiants algériens vers l'excellence académique grâce à l'IA.
                        </p>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-white mb-6">Outils</h4>
                        <ul class="space-y-4 text-[11px] font-medium text-slate-400">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Résolveur d'Exercices</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Résumeur de Cours</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Générateur de Flashcards</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-white mb-6">Plateforme</h4>
                        <ul class="space-y-4 text-[11px] font-medium text-slate-400">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Connexion</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Inscription</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Statut du Système</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-white mb-6">Légal</h4>
                        <ul class="space-y-4 text-[11px] font-medium text-slate-400">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Confidentialité</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Conditions d'Utilisation</a></li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 border-t border-white/5 pt-12">
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Studdy-Freind &copy; {{ date('Y') }} // Algérie</p>
                </div>
            </footer>
        </div>

        <script>
            // Reveal animations on scroll
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        </script>
    </body>
</html>
