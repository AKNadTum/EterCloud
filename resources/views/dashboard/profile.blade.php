@extends('dashboard.layout')

@section('title', 'Profil')

@section('dashboard')
    <div class="space-y-4">
        <x-ui.card title="Informations du compte">
            <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.input name="first_name" label="Prénom" :value="auth()->user()->first_name" />
                    <x-ui.input name="last_name" label="Nom de famille" :value="auth()->user()->last_name" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.input name="name" label="Nom complet" :value="auth()->user()->name" description="Si laissé vide, il peut être composé automatiquement depuis prénom et nom." />

                    <x-ui.input name="email" required>
                        <x-slot:label>
                            <div class="flex items-center gap-2">
                                <span>Adresse e‑mail</span>
                                @if(auth()->user()->hasVerifiedEmail())
                                    <x-ui.badge variant="success-subtle" size="sm" class="shrink-0 whitespace-nowrap">
                                        <x-heroicon-s-check-circle class="size-3 mr-1" />
                                        Vérifié
                                    </x-ui.badge>
                                @else
                                    <x-ui.badge variant="warning-subtle" size="sm" class="shrink-0 whitespace-nowrap">
                                        <x-heroicon-s-exclamation-triangle class="size-3 mr-1" />
                                        Non vérifié
                                    </x-ui.badge>
                                @endif
                            </div>
                        </x-slot:label>

                        <x-ui.input id="email" name="email" type="email" required
                                    :invalid="$errors->has('email')"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full" />
                    </x-ui.input>
                </div>

                <div class="pt-2">
                    <x-ui.button type="submit">
                        Enregistrer
                    </x-ui.button>
                </div>
            </form>

            @if (! auth()->user()->hasVerifiedEmail())
                <div class="mt-6 p-4 rounded-lg bg-[var(--warning)]/10 border border-[var(--warning)]/20 animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex items-start gap-3 text-[var(--warning-foreground)]">
                        <x-heroicon-o-information-circle class="size-5 shrink-0 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-bold">Votre adresse e-mail n'est pas encore vérifiée.</p>
                            <p class="mt-1 opacity-90">Veuillez cliquer sur le lien envoyé par e-mail pour valider votre compte. Si vous ne l'avez pas reçu, vous pouvez en demander un nouveau.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                        @csrf
                        <x-ui.button type="submit" variant="outline" size="sm" class="bg-[var(--warning)]/10 hover:bg-[var(--warning)]/20 border-[var(--warning)]/30 text-[var(--warning-foreground)] shadow-sm">
                            <x-heroicon-o-paper-airplane class="size-3.5 mr-2" />
                            Renvoyer l'e-mail de vérification
                        </x-ui.button>
                    </form>
                </div>
            @endif
        </x-ui.card>

        <x-ui.card title="Pterodactyl">
            @php($pid = auth()->user()->pterodactyl_user_id)
            <div class="mt-2">
                <div class="text-sm text-[var(--foreground)] flex items-center gap-2">
                    @if ($pid)
                        <span class="h-2 w-2 rounded-full bg-[var(--success-foreground)]"></span>
                        <span>Compte lié (ID: {{ $pid }})</span>
                    @else
                        <span class="h-2 w-2 rounded-full bg-[var(--muted-foreground)]"></span>
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
                        <x-ui.input
                            name="ptero_password"
                            type="password"
                            label="Mot de passe du compte (optionnel)"
                            description="Utilisé uniquement si un compte doit être créé sur le panel. Le mot de passe n'est pas conservé."
                        />
                    @endif

                    <x-ui.button type="submit">
                        {{ $pid ? 'Synchroniser' : 'Lier / Créer' }}
                    </x-ui.button>
                </form>
            </div>
        </x-ui.card>

        <x-ui.card>
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold text-[var(--foreground)]">Facturation</div>
                    <x-ui.badge variant="accent-subtle" size="sm">Stripe</x-ui.badge>
                </div>
            </x-slot>

            <div class="text-sm">
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

                                Vous n'avez pas encore de compte de facturation Stripe lié.
                                Un compte Stripe est requis pour souscrire à un abonnement et gérer vos serveurs.

                        </x-ui.alert>

                        <form method="POST" action="{{ route('dashboard.profile.stripe.link') }}">
                            @csrf
                            <x-ui.button type="submit">
                                Lier / Créer mon compte Stripe
                            </x-ui.button>
                        </form>

                        @error('stripe')
                            <p class="text-xs text-[var(--destructive-foreground)] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
        </x-ui.card>

        <x-ui.card title="Sécurité">
            <form method="POST" action="{{ route('dashboard.profile.password') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.input name="current_password" type="password" label="Mot de passe actuel" required />
                    <x-ui.input name="password" type="password" label="Nouveau mot de passe" required />
                    <x-ui.input name="password_confirmation" type="password" label="Confirmer le nouveau mot de passe" required />
                </div>

                <div class="pt-2">
                    <x-ui.button type="submit">
                        Mettre à jour le mot de passe
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection









