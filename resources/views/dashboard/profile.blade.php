@extends('dashboard.layout')

@section('title', 'Profil')

@section('dashboard')
    <div class="space-y-4">
        <div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-4">
            <div class="text-sm text-[var(--muted-foreground)]">Informations du compte</div>
            <form method="POST" action="{{ route('dashboard.profile.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-[var(--foreground)]">Prénom</label>
                        <x-ui.input id="first_name" name="first_name" type="text"
                                    :invalid="$errors->has('first_name')"
                                    value="{{ old('first_name', auth()->user()->first_name) }}"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-[var(--foreground)]">Nom de famille</label>
                        <x-ui.input id="last_name" name="last_name" type="text"
                                    :invalid="$errors->has('last_name')"
                                    value="{{ old('last_name', auth()->user()->last_name) }}"
                                    class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[var(--foreground)]">Nom complet</label>
                        <x-ui.input id="name" name="name" type="text"
                                    :invalid="$errors->has('name')"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    class="mt-1" />
                        <p class="mt-1 text-xs text-[var(--muted-foreground)]">Si laissé vide, il peut être composé automatiquement depuis prénom et nom.</p>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-[var(--foreground)]">Adresse e‑mail</label>
                        <div class="mt-1 flex flex-col sm:flex-row items-start sm:items-center gap-2">
                            <x-ui.input id="email" name="email" type="email" required
                                        :invalid="$errors->has('email')"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        class="flex-1 w-full" />
                            @if(auth()->user()->hasVerifiedEmail())
                                <x-ui.badge variant="success" size="sm" class="shrink-0 whitespace-nowrap">
                                    <x-heroicon-s-check-circle class="size-3 mr-1" />
                                    Vérifié
                                </x-ui.badge>
                            @else
                                <x-ui.badge variant="warning" size="sm" class="shrink-0 whitespace-nowrap">
                                    <x-heroicon-s-exclamation-triangle class="size-3 mr-1" />
                                    Non vérifié
                                </x-ui.badge>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <x-ui.button type="submit">
                        Enregistrer
                    </x-ui.button>
                </div>
            </form>

            @if (! auth()->user()->hasVerifiedEmail())
                <div class="mt-6 p-4 rounded-lg bg-amber-500/10 border border-amber-500/20 animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex items-start gap-3 text-amber-500">
                        <x-heroicon-o-information-circle class="size-5 shrink-0 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-bold">Votre adresse e-mail n'est pas encore vérifiée.</p>
                            <p class="mt-1 opacity-90">Veuillez cliquer sur le lien envoyé par e-mail pour valider votre compte. Si vous ne l'avez pas reçu, vous pouvez en demander un nouveau.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                        @csrf
                        <x-ui.button type="submit" variant="outline" size="sm" class="bg-amber-500/10 hover:bg-amber-500/20 border-amber-500/30 text-amber-500 shadow-sm">
                            <x-heroicon-o-paper-airplane class="size-3.5 mr-2" />
                            Renvoyer l'e-mail de vérification
                        </x-ui.button>
                    </form>
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-4">
            <div class="text-sm text-[var(--muted-foreground)]">Pterodactyl</div>
            @php($pid = auth()->user()->pterodactyl_user_id)
            <div class="mt-4">
                <div class="text-sm text-[var(--foreground)] flex items-center gap-2">
                    @if ($pid)
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        <span>Compte lié (ID: {{ $pid }})</span>
                    @else
                        <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                        <span>Aucun compte lié</span>
                    @endif
                </div>

                @if ($pid && isset($ptero) && is_array($ptero))
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-[var(--muted-foreground)]">Email</div>
                            <div class="font-medium text-[var(--foreground)]">{{ $ptero['email'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-[var(--muted-foreground)]">Nom d'utilisateur</div>
                            <div class="font-medium text-[var(--foreground)]">{{ $ptero['username'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-[var(--muted-foreground)]">Prénom</div>
                            <div class="font-medium text-[var(--foreground)]">{{ $ptero['first_name'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-[var(--muted-foreground)]">Nom</div>
                            <div class="font-medium text-[var(--foreground)]">{{ $ptero['last_name'] ?? '—' }}</div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.profile.pterodactyl.link') }}" class="mt-4 space-y-3">
                    @csrf

                    @if (! $pid)
                        <div>
                            <label for="ptero_password" class="block text-sm font-medium text-[var(--foreground)]">Mot de passe du compte (optionnel)</label>
                            <x-ui.input id="ptero_password" name="ptero_password" type="password"
                                        :invalid="$errors->has('ptero_password')"
                                        class="mt-1" />
                            <p class="mt-1 text-xs text-[var(--muted-foreground)]">Utilisé uniquement si un compte doit être créé sur le panel. Le mot de passe n'est pas conservé.</p>
                            @error('ptero_password')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <x-ui.button type="submit">
                        {{ $pid ? 'Synchroniser' : 'Lier / Créer' }}
                    </x-ui.button>
                </form>
            </div>
        </div>

        <div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-4">
            <details class="group">
                <summary class="list-none cursor-pointer flex items-center justify-between">
                    <div class="text-sm text-[var(--muted-foreground)]">Facturation</div>
                    <div class="flex items-center gap-2 text-xs text-[var(--link)] font-medium bg-[var(--primary)]/50 px-3 py-1 rounded-full hover:bg-[var(--primary)] transition-colors">
                        <span class="group-open:hidden">Afficher les informations</span>
                        <span class="hidden group-open:inline">Masquer les informations</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3 transition-transform group-open:rotate-180">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </summary>
                <div class="mt-6 text-sm">
                    @if(isset($billing) && is_array($billing) && isset($billing['customer']) && $billing['customer'] !== null)
                        @php($customer = $billing['customer'])
                        @php($subscription = $billing['subscription'] ?? null)
                        @php($currentPlan = $billing['plan'] ?? null)

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider mb-1">Customer ID</div>
                                <div class="font-mono text-xs bg-[var(--secondary)] p-2 rounded border border-[var(--border)] break-all select-all text-[var(--foreground)]">{{ $customer->id }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider mb-1">Email (Stripe)</div>
                                <div class="font-medium p-2 text-[var(--foreground)]">{{ $customer->email ?? auth()->user()->email }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider mb-2">Statut de l'abonnement</div>
                                <div class="flex items-center gap-3 bg-[var(--secondary)] p-3 rounded-lg border border-[var(--border)]">
                                    @if($subscription)
                                        <x-ui.badge variant="success" size="sm">
                                            {{ ucfirst(str_replace('_',' ', $subscription->status)) }}
                                        </x-ui.badge>
                                        @if($currentPlan)
                                            <span class="text-sm font-medium text-[var(--foreground)]">Plan actuel : <span class="text-[var(--accent-foreground)]">{{ $currentPlan->name }}</span></span>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-2 text-[var(--muted-foreground)] italic">
                                            <x-heroicon-o-x-circle class="size-4" />
                                            Aucun abonnement actif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-4 border-t border-[var(--border)] flex justify-end">
                            <x-ui.button href="{{ route('billing.overview') }}" variant="outline" size="sm">
                                <x-heroicon-o-arrow-top-right-on-square class="size-4 mr-2" />
                                Gérer sur le portail Stripe
                            </x-ui.button>
                        </div>
                    @else
                        <div class="space-y-4">
                            <x-ui.alert variant="info" class="p-4">
                                <x-heroicon-o-information-circle class="size-5" />
                                <x-ui.alert-description class="italic text-sm">
                                    Vous n'avez pas encore de compte de facturation Stripe lié.
                                    Un compte Stripe est requis pour souscrire à un abonnement et gérer vos serveurs.
                                </x-ui.alert-description>
                            </x-ui.alert>

                            <form method="POST" action="{{ route('dashboard.profile.stripe.link') }}">
                                @csrf
                                <x-ui.button type="submit">
                                    Lier / Créer mon compte Stripe
                                </x-ui.button>
                            </form>

                            @error('stripe')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>
            </details>
        </div>

        <div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-4">
            <div class="text-sm text-[var(--muted-foreground)]">Sécurité</div>
            <form method="POST" action="{{ route('dashboard.profile.password') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-[var(--foreground)]">Mot de passe actuel</label>
                        <x-ui.input id="current_password" name="current_password" type="password" required
                                    :invalid="$errors->has('current_password')"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-[var(--foreground)]">Nouveau mot de passe</label>
                        <x-ui.input id="password" name="password" type="password" required
                                    :invalid="$errors->has('password')"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[var(--foreground)]">Confirmer le nouveau mot de passe</label>
                        <x-ui.input id="password_confirmation" name="password_confirmation" type="password" required
                                    :invalid="$errors->has('password_confirmation')"
                                    class="mt-1" />
                    </div>
                </div>

                <div class="pt-2">
                    <x-ui.button type="submit">
                        Mettre à jour le mot de passe
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
@endsection
