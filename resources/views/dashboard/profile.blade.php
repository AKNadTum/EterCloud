@extends('dashboard.layout')

@section('title', 'Profil')

@section('dashboard')
    <div class="space-y-4">
        <div class="rounded-lg border border-border bg-white p-4">
            <div class="text-sm text-gray-500">Informations du compte</div>
            <form method="POST" action="{{ route('dashboard.profile.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <x-ui.input id="first_name" name="first_name" type="text"
                                    :invalid="$errors->has('first_name')"
                                    value="{{ old('first_name', auth()->user()->first_name) }}"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom de famille</label>
                        <x-ui.input id="last_name" name="last_name" type="text"
                                    :invalid="$errors->has('last_name')"
                                    value="{{ old('last_name', auth()->user()->last_name) }}"
                                    class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <x-ui.input id="name" name="name" type="text"
                                    :invalid="$errors->has('name')"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    class="mt-1" />
                        <p class="mt-1 text-xs text-gray-500">Si laissé vide, il peut être composé automatiquement depuis prénom et nom.</p>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e‑mail</label>
                        <x-ui.input id="email" name="email" type="email" required
                                    :invalid="$errors->has('email')"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    class="mt-1" />
                    </div>
                </div>

                <div class="pt-2">
                    <x-ui.button type="submit">
                        Enregistrer
                    </x-ui.button>
                </div>
            </form>
        </div>

        <div class="rounded-lg border border-border bg-white p-4">
            <div class="text-sm text-gray-500">Pterodactyl</div>
            @php($pid = auth()->user()->pterodactyl_user_id)
            <div class="mt-4">
                <div class="text-sm text-gray-700 flex items-center gap-2">
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
                            <div class="text-gray-500">Email</div>
                            <div class="font-medium">{{ $ptero['email'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-gray-500">Nom d'utilisateur</div>
                            <div class="font-medium">{{ $ptero['username'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-gray-500">Prénom</div>
                            <div class="font-medium">{{ $ptero['first_name'] ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-gray-500">Nom</div>
                            <div class="font-medium">{{ $ptero['last_name'] ?? '—' }}</div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.profile.pterodactyl.link') }}" class="mt-4 space-y-3">
                    @csrf

                    @if (! $pid)
                        <div>
                            <label for="ptero_password" class="block text-sm font-medium text-gray-700">Mot de passe du compte (optionnel)</label>
                            <x-ui.input id="ptero_password" name="ptero_password" type="password"
                                        :invalid="$errors->has('ptero_password')"
                                        class="mt-1" />
                            <p class="mt-1 text-xs text-gray-500">Utilisé uniquement si un compte doit être créé sur le panel. Le mot de passe n'est pas conservé.</p>
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

        <div class="rounded-lg border border-border bg-white p-4">
            <details class="group">
                <summary class="list-none cursor-pointer flex items-center justify-between">
                    <div class="text-sm text-gray-500">Facturation</div>
                    <div class="flex items-center gap-2 text-xs text-[var(--link)] font-medium bg-[var(--primary)]/50 px-3 py-1 rounded-full hover:bg-[var(--primary)] transition-colors">
                        <span class="group-open:hidden">Afficher les informations</span>
                        <span class="hidden group-open:inline">Masquer les informations</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3 transition-transform group-open:rotate-180">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </summary>
                <div class="mt-6 text-sm">
                    @if(isset($billing) && is_array($billing) && isset($billing['customer']))
                        @php($customer = $billing['customer'])
                        @php($subscription = $billing['subscription'] ?? null)
                        @php($currentPlan = $billing['plan'] ?? null)

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Customer ID</div>
                                <div class="font-mono text-xs bg-gray-50 p-2 rounded border border-gray-100 break-all select-all">{{ $customer->id }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email (Stripe)</div>
                                <div class="font-medium p-2">{{ $customer->email ?? auth()->user()->email }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Statut de l'abonnement</div>
                                <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    @if($subscription)
                                        <x-ui.badge variant="success" size="sm">
                                            {{ ucfirst(str_replace('_',' ', $subscription->status)) }}
                                        </x-ui.badge>
                                        @if($currentPlan)
                                            <span class="text-sm font-medium">Plan actuel : <span class="text-[var(--accent-foreground)]">{{ $currentPlan->name }}</span></span>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400 italic">
                                            <x-heroicon-o-x-circle class="size-4" />
                                            Aucun abonnement actif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <x-ui.alert variant="info" class="p-4">
                            <x-heroicon-o-information-circle class="size-5" />
                            <x-ui.alert-description class="italic">
                                Informations Stripe indisponibles pour le moment.
                            </x-ui.alert-description>
                        </x-ui.alert>
                    @endif

                    <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
                        <x-ui.button href="{{ route('billing.overview') }}" variant="outline" size="sm">
                            <x-heroicon-o-arrow-top-right-on-square class="size-4 mr-2" />
                            Gérer sur le portail Stripe
                        </x-ui.button>
                    </div>
                </div>
            </details>
        </div>

        <div class="rounded-lg border border-border bg-white p-4">
            <div class="text-sm text-gray-500">Sécurité</div>
            <form method="POST" action="{{ route('dashboard.profile.password') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                        <x-ui.input id="current_password" name="current_password" type="password" required
                                    :invalid="$errors->has('current_password')"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                        <x-ui.input id="password" name="password" type="password" required
                                    :invalid="$errors->has('password')"
                                    class="mt-1" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
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
