@extends('dashboard.layout')

@section('title', 'Créer un serveur')

@section('dashboard')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-ui.button variant="ghost" size="icon" href="{{ route('dashboard.servers') }}" class="-ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </x-ui.button>
                <h2 class="text-xl font-semibold text-[var(--foreground)]">Nouveau serveur</h2>
            </div>
            @if ($plan)
                <div class="text-sm text-[var(--muted-foreground)]">
                    Plan : <strong>{{ $plan->name }}</strong>
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-6 shadow-sm">
            <form method="POST" action="{{ route('dashboard.servers.store') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nom du serveur</label>
                    <x-ui.input type="text" name="name" id="name" required maxlength="80" placeholder="Mon serveur Minecraft" />
                    <p class="text-xs text-[var(--muted-foreground)]">Choisissez un nom reconnaissable pour votre serveur.</p>
                </div>

                <div class="space-y-1.5">
                    <label for="location_id" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Localisation</label>
                    <select name="location_id" id="location_id" required
                            class="flex h-10 w-full rounded-md border border-[var(--input)] bg-[var(--control-background)] px-3 py-2 text-sm ring-offset-[var(--background)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        @foreach ($locations as $location)
                            <option value="{{ $location->ptero_id_location }}">{{ $location->display_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[var(--muted-foreground)]">Disponible selon votre plan actuel : <strong>{{ $plan->name }}</strong>.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="nest_id" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Type de jeu (Nest)</label>
                        <select name="nest_id" id="nest_id" required
                                class="flex h-10 w-full rounded-md border border-[var(--input)] bg-[var(--control-background)] px-3 py-2 text-sm ring-offset-[var(--background)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            @foreach ($nests['data'] as $nest)
                                <option value="{{ $nest['attributes']['id'] }}">{{ $nest['attributes']['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label for="egg_id" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Version / Logiciel (Egg)</label>
                        <select name="egg_id" id="egg_id" required
                                class="flex h-10 w-full rounded-md border border-[var(--input)] bg-[var(--control-background)] px-3 py-2 text-sm ring-offset-[var(--background)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="">Sélectionnez d'abord un type de jeu</option>
                        </select>
                    </div>
                </div>

                <x-ui.alert variant="default" class="bg-[var(--secondary)] border-[var(--border)]">
                    <x-heroicon-o-information-circle class="size-5 text-gray-400" />
                    <x-ui.alert-title class="text-[var(--foreground)]">Ressources incluses dans votre plan</x-ui.alert-title>
                    <x-ui.alert-description class="text-[var(--foreground)]">
                        <ul class="list-disc space-y-1 pl-5">
                            <li>Instances : {{ $plan->server_limit }} serveur{{ $plan->server_limit > 1 ? 's' : '' }}</li>
                            <li>Stockage : {{ $plan->disk / 1024 }} GB</li>
                            <li>Sauvegardes : {{ $plan->backups_limit }}</li>
                            <li>Bases de données : {{ $plan->databases_limit }}</li>
                            <li>CPU : {{ $plan->cpu > 0 ? $plan->cpu . '%' : 'Illimité' }}</li>
                            <li>RAM : {{ $plan->memory > 0 ? ($plan->memory / 1024) . ' GB' : 'Illimitée' }}</li>
                        </ul>
                    </x-ui.alert-description>
                </x-ui.alert>

                <div class="pt-4">
                    <x-ui.button type="submit" class="w-full">
                        Déployer le serveur
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Logique simple pour charger les Eggs selon le Nest choisi
        document.getElementById('nest_id').addEventListener('change', function() {
            const nestId = this.value;
            const eggSelect = document.getElementById('egg_id');
            eggSelect.innerHTML = '<option value="">Chargement...</option>';

            // Utilisation de la route nommée pour construire l'URL (plus propre)
            const url = "{{ route('dashboard.api.eggs', ['nestId' => ':nestId']) }}".replace(':nestId', nestId);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    eggSelect.innerHTML = '';
                    data.forEach(egg => {
                        const option = document.createElement('option');
                        option.value = egg.id;
                        option.textContent = egg.name;
                        eggSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    eggSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    console.error('Error fetching eggs:', error);
                });
        });

        // Trigger change on load if nest_id is selected
        if (document.getElementById('nest_id').value) {
            document.getElementById('nest_id').dispatchEvent(new Event('change'));
        }
    </script>
@endsection

