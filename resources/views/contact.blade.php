@extends('layout')

@section('content')
    <section class="py-16 md:py-24 relative overflow-hidden">
        <!-- Éléments de décor en arrière-plan -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] size-96 bg-[var(--primary)]/20 blur-[100px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[10%] right-[-5%] size-80 bg-[var(--accent)]/15 blur-[80px] rounded-full animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <div class="mx-auto px-4" style="max-width: 70%;">
            <div class="mb-16 text-center">
                <div class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-[var(--primary-foreground)] bg-[var(--primary)]/50 px-3 py-1 rounded-full border border-[var(--primary-foreground)]/10 mb-4">
                    <span>Contact</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-balance">
                    Comment pouvons-nous vous <span class="text-[var(--primary-foreground)]">aider</span> ?
                </h1>
                <p class="mt-4 text-muted-foreground text-lg max-w-2xl mx-auto leading-relaxed">
                    Une question, un souci technique ou un retour à nous faire ? Notre équipe est là pour vous accompagner.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                <!-- Formulaire de contact -->
                <div class="lg:col-span-2">
                    <div class="glass-card p-8 md:p-12 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                            <x-heroicon-o-paper-airplane class="size-32 -rotate-12" />
                        </div>

                        @auth
                            <form method="post" action="{{ route('contact.submit') }}" class="relative space-y-8">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label for="name" class="text-sm font-bold flex items-center gap-2">
                                            <x-heroicon-o-user class="size-4 text-muted-foreground" />
                                            Votre Nom
                                        </label>
                                        <x-ui.input id="name" name="name" :value="auth()->user()->display_name" disabled />
                                    </div>
                                    <div class="space-y-3">
                                        <label for="reason" class="text-sm font-bold flex items-center gap-2">
                                            <x-heroicon-o-chat-bubble-bottom-center-text class="size-4 text-muted-foreground" />
                                            Raison de votre ticket
                                        </label>
                                        <select id="reason" name="reason" class="w-full rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-4 py-3 text-sm text-[var(--control-foreground)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 ring-offset-[var(--background)] transition-all" required>
                                            <option value="" disabled {{ !isset($preselectedReason) ? 'selected' : '' }}>Sélectionnez une raison</option>
                                            @foreach($reasons as $key => $reason)
                                                <option value="{{ $key }}" {{ (old('reason') ?? ($preselectedReason ?? '')) == $key ? 'selected' : '' }}>{{ $reason['label'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('reason')
                                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label for="subject" class="text-sm font-bold flex items-center gap-2">
                                        <x-heroicon-o-tag class="size-4 text-muted-foreground" />
                                        Sujet (optionnel)
                                    </label>
                                    <x-ui.input id="subject" name="subject" :value="old('subject')" placeholder="Laissez vide pour utiliser la raison par défaut" />
                                    @error('subject')
                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="message" class="text-sm font-bold flex items-center gap-2">
                                        <x-heroicon-o-pencil-square class="size-4 text-muted-foreground" />
                                        Message
                                    </label>
                                    <textarea id="message" name="message" rows="6"
                                              class="w-full rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-4 py-3 text-sm text-[var(--control-foreground)] placeholder:text-[var(--muted-foreground)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 ring-offset-[var(--background)] transition-all resize-none"
                                              placeholder="Décrivez votre demande en détail...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-4">
                                    <x-ui.button type="submit" size="lg" class="w-full md:w-auto px-12 font-bold shadow-xl shadow-[var(--primary)]/30 hover:scale-[1.02] transition-transform">
                                        Ouvrir le ticket
                                    </x-ui.button>
                                </div>
                            </form>
                        @else
                            <div class="relative py-12 text-center space-y-6">
                                <div class="size-20 bg-[var(--primary)]/10 text-[var(--primary-foreground)] rounded-full flex items-center justify-center mx-auto mb-4">
                                    <x-heroicon-o-lock-closed class="size-10" />
                                </div>
                                <h3 class="text-2xl font-bold">Connexion requise</h3>
                                <p class="text-muted-foreground max-w-md mx-auto">
                                    Vous devez être connecté à votre compte EterCloud pour ouvrir un ticket de support et discuter avec nos agents.
                                </p>
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                                    <x-ui.button href="{{ route('login') }}" size="lg" class="w-full sm:w-auto px-8">
                                        Se connecter
                                    </x-ui.button>
                                    <x-ui.button href="{{ route('register') }}" variant="outline" size="lg" class="w-full sm:w-auto px-8">
                                        Créer un compte
                                    </x-ui.button>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Informations latérales -->
                <div class="space-y-8">
                    <div class="glass-card card-accent p-8 group hover:-translate-y-1 transition-all duration-300">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-[var(--accent)]/50 text-[var(--accent-foreground)]">
                                <x-heroicon-o-lifebuoy class="size-6" />
                            </div>
                            Assistance
                        </h3>
                        <p class="text-sm text-muted-foreground leading-relaxed mb-8">
                            Notre équipe est mobilisée pour vous répondre sous <span class="font-bold text-foreground">24h ouvrées</span>.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4 group/item">
                                <div class="size-12 rounded-2xl bg-white border border-[var(--border)] flex items-center justify-center shrink-0 group-hover/item:border-[var(--primary-foreground)]/30 group-hover/item:shadow-md transition-all">
                                    <x-heroicon-o-envelope class="size-6 text-[var(--primary-foreground)]" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Email</p>
                                    <p class="text-sm font-semibold">eternom@icloud.com</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group/item">
                                <div class="size-12 rounded-2xl bg-white border border-[var(--border)] flex items-center justify-center shrink-0 group-hover/item:border-[#5865F2]/30 group-hover/item:shadow-md transition-all">
                                    <x-heroicon-s-chat-bubble-left-right class="size-6 text-[#5865F2]" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Discord</p>
                                    <p class="text-sm font-semibold italic opacity-60">Prochainement...</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group/item">
                                <div class="size-12 rounded-2xl bg-white border border-[var(--border)] flex items-center justify-center shrink-0 group-hover/item:border-[var(--warning-foreground)]/30 group-hover/item:shadow-md transition-all">
                                    <x-heroicon-o-clock class="size-6 text-[var(--warning-foreground)]" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Disponibilité</p>
                                    <p class="text-sm font-semibold">Lun-Ven, 10h-18h</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-8 bg-gradient-to-br from-white to-[var(--secondary)]/50 border-none shadow-inner">
                        <h3 class="font-bold mb-3">Besoin d'un plan ?</h3>
                        <p class="text-sm text-muted-foreground mb-6 leading-relaxed">Explorez nos offres d'hébergement performantes pour tous vos projets.</p>
                        <x-ui.button href="{{ route('home') }}#plans" variant="outline" class="w-full justify-center font-bold bg-white/50 backdrop-blur-sm border-[var(--primary-foreground)]/20 hover:bg-white transition-colors">
                            Voir les tarifs
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reasonSelect = document.getElementById('reason');
                const messageTextarea = document.getElementById('message');

                const templates = {
                    'quote_request': "Bonjour,\n\nJe souhaiterais obtenir un devis pour un plan sur mesure.\n\nVoici mes besoins :\n- CPU :\n- RAM :\n- Stockage :\n- Usage prévu :\n\nMerci d'avance.",
                };

                reasonSelect.addEventListener('change', function() {
                    const selectedReason = this.value;
                    if (templates[selectedReason] && messageTextarea.value.trim() === '') {
                        messageTextarea.value = templates[selectedReason];
                    }
                });

                // Trigger on load if reason is already selected
                if (reasonSelect.value && templates[reasonSelect.value] && messageTextarea.value.trim() === '') {
                    messageTextarea.value = templates[reasonSelect.value];
                }
            });
        </script>
    @endauth
@endsection
