@extends('layout')

@section('content')
    <section class="py-16 md:py-24 relative overflow-hidden">
        <!-- Éléments de décor en arrière-plan -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] size-96 bg-[var(--primary)]/20 blur-[100px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[10%] right-[-5%] size-80 bg-[var(--accent)]/15 blur-[80px] rounded-full animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <div class="mx-auto px-4" style="max-width: 65%;">
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

                        <form method="post" action="#" class="relative space-y-8">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label for="name" class="text-sm font-bold flex items-center gap-2">
                                        <x-heroicon-o-user class="size-4 text-muted-foreground" />
                                        Votre Nom
                                    </label>
                                    <x-ui.input id="name" name="name" :value="old('name')" placeholder="Jean Dupont" required />
                                    @error('name')
                                        <p class="mt-1 text-xs text-[var(--destructive-foreground)]">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-3">
                                    <label for="email" class="text-sm font-bold flex items-center gap-2">
                                        <x-heroicon-o-envelope class="size-4 text-muted-foreground" />
                                        Votre Email
                                    </label>
                                    <x-ui.input id="email" type="email" name="email" :value="old('email')" placeholder="jean@exemple.com" required />
                                    @error('email')
                                        <p class="mt-1 text-xs text-[var(--destructive-foreground)]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label for="subject" class="text-sm font-bold flex items-center gap-2">
                                    <x-heroicon-o-chat-bubble-bottom-center-text class="size-4 text-muted-foreground" />
                                    Sujet de votre message
                                </label>
                                <x-ui.input id="subject" name="subject" :value="old('subject')" placeholder="En quoi pouvons-nous vous aider ?" required />
                                @error('subject')
                                    <p class="mt-1 text-xs text-[var(--destructive-foreground)]">{{ $message }}</p>
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
                                    <p class="mt-1 text-xs text-[var(--destructive-foreground)]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <x-ui.button type="submit" size="lg" class="w-full md:w-auto px-12 font-bold shadow-xl shadow-[var(--primary)]/30 hover:scale-[1.02] transition-transform">
                                    Envoyer mon message
                                </x-ui.button>
                            </div>
                        </form>
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
                                    <p class="text-sm font-semibold">support@eternom.fr</p>
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
@endsection
