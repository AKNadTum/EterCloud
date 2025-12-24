<footer class="mt-12 border-t bg-[var(--background)]/90 backdrop-blur-md">
    <div class="container-custom py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
            <!-- Brand -->
            <div>
                <div class="text-lg font-semibold tracking-tight">{{ config('app.name') }}</div>
                <p class="mt-2 text-sm opacity-70 leading-relaxed">
                    L'alternative à Aternos pour votre <strong>hébergement Minecraft gratuit</strong>.
                    Profitez de vraies performances sans file d'attente et sans lag.
                </p>
            </div>

            <!-- Produit -->
            <div>
                <div class="text-sm font-semibold mb-3">Produit</div>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="/" class="transition hover:text-[var(--accent-foreground)]">Accueil</a></li>
                    <li><a href="{{ route('home') }}#plans" class="transition hover:text-[var(--accent-foreground)]">Plans</a></li>
                    <li><a href="#" class="transition hover:text-[var(--accent-foreground)]">Serveurs</a></li>
                </ul>
            </div>

            <!-- Ressources -->
            <div>
                <div class="text-sm font-semibold mb-3">Ressources</div>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="#" class="transition hover:text-[var(--accent-foreground)]">Documentation</a></li>
                    <li><a href="{{ route('status') }}" class="transition hover:text-[var(--accent-foreground)]">Statut</a></li>
                    <li><a href="#" class="transition hover:text-[var(--accent-foreground)]">API</a></li>
                </ul>
            </div>

            <!-- Légal -->
            <div>
                <div class="text-sm font-semibold mb-3">Légal</div>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="{{ route('legal.tos') }}" class="transition hover:text-[var(--accent-foreground)]">CGU</a></li>
                    <li><a href="{{ route('legal.privacy') }}" class="transition hover:text-[var(--accent-foreground)]">Confidentialité</a></li>
                    <li><a href="{{ route('legal.mentions') }}" class="transition hover:text-[var(--accent-foreground)]">Mentions Légales</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <div class="text-sm font-semibold mb-3">Support</div>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="{{ route('legal.refund') }}" class="transition hover:text-[var(--accent-foreground)]">Remboursement</a></li>
                    <li><a href="/contact" class="transition hover:text-[var(--accent-foreground)]">Contact</a></li>
                    <li><a href="mailto:eternom@icloud.com" class="transition hover:text-[var(--accent-foreground)]">Email Support</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="mt-10 pt-6 border-t flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs opacity-70 text-center md:text-left">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </p>

            <div class="flex items-center gap-4">
                <a href="#" aria-label="GitHub" class="opacity-70 hover:opacity-100 hover:text-[var(--accent-foreground)] transition" title="GitHub">
                    <x-heroicon-o-code-bracket class="w-5 h-5" aria-hidden="true" />
                </a>
                <a href="#" aria-label="X (Twitter)" class="opacity-70 hover:opacity-100 hover:text-[var(--accent-foreground)] transition" title="X (Twitter)">
                    <x-heroicon-o-hashtag class="w-5 h-5" aria-hidden="true" />
                </a>
                <a href="#" aria-label="Discord" class="opacity-70 hover:opacity-100 hover:text-[var(--accent-foreground)] transition" title="Discord">
                    <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" aria-hidden="true" />
                </a>
            </div>
        </div>
    </div>
</footer>








