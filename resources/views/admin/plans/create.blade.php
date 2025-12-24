@extends('admin.layout')

@section('title', 'Nouveau Plan')

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-4xl">
        <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-[var(--foreground)] mb-1">Nom du Plan</label>
                    <x-ui.input type="text" name="name" id="name" value="{{ old('name') }}" required :invalid="$errors->has('name')" placeholder="Ex: Plan Premium" />
                    @error('name') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-[var(--foreground)] mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-3 py-2 text-sm text-[var(--control-foreground)] focus:outline-none focus:ring-2 focus:ring-[var(--ring)] focus:ring-offset-2 ring-offset-[var(--background)] transition-colors @error('description') border-[var(--destructive)] @enderror" placeholder="Description détaillée du plan...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price_stripe_id" class="block text-sm font-medium text-[var(--foreground)] mb-1">Stripe Price ID</label>
                    <x-ui.input type="text" name="price_stripe_id" id="price_stripe_id" value="{{ old('price_stripe_id') }}" required :invalid="$errors->has('price_stripe_id')" placeholder="price_..." />
                    @error('price_stripe_id') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="server_limit" class="block text-sm font-medium text-[var(--foreground)] mb-1">Limite de Serveurs</label>
                    <x-ui.input type="number" name="server_limit" id="server_limit" value="{{ old('server_limit', 1) }}" required :invalid="$errors->has('server_limit')" />
                    @error('server_limit') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="cpu" class="block text-sm font-medium text-[var(--foreground)] mb-1">CPU (%) (0 = illimité)</label>
                    <x-ui.input type="number" name="cpu" id="cpu" value="{{ old('cpu', 100) }}" required :invalid="$errors->has('cpu')" />
                    @error('cpu') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="memory" class="block text-sm font-medium text-[var(--foreground)] mb-1">Mémoire (MB) (0 = illimitée)</label>
                    <x-ui.input type="number" name="memory" id="memory" value="{{ old('memory', 1024) }}" required :invalid="$errors->has('memory')" />
                    @error('memory') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="disk" class="block text-sm font-medium text-[var(--foreground)] mb-1">Disque (MB)</label>
                    <x-ui.input type="number" name="disk" id="disk" value="{{ old('disk', 5120) }}" required :invalid="$errors->has('disk')" />
                    @error('disk') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="databases_limit" class="block text-sm font-medium text-[var(--foreground)] mb-1">Limite Bases de données</label>
                    <x-ui.input type="number" name="databases_limit" id="databases_limit" value="{{ old('databases_limit', 1) }}" required :invalid="$errors->has('databases_limit')" />
                    @error('databases_limit') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="backups_limit" class="block text-sm font-medium text-[var(--foreground)] mb-1">Limite Backups</label>
                    <x-ui.input type="number" name="backups_limit" id="backups_limit" value="{{ old('backups_limit', 1) }}" required :invalid="$errors->has('backups_limit')" />
                    @error('backups_limit') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 border-t border-[var(--border)] pt-4">
                    <label class="block text-sm font-medium text-[var(--foreground)] mb-3">Localisations autorisées</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($locations as $location)
                            <div class="flex items-center gap-2 group cursor-pointer">
                                <input type="checkbox" name="locations[]" id="location_{{ $location->id }}" value="{{ $location->id }}"
                                    {{ in_array($location->id, old('locations', [])) ? 'checked' : '' }}
                                    class="size-4 rounded border-[var(--border)] text-[var(--primary-foreground)] focus:ring-[var(--ring)] bg-[var(--control-background)] transition-colors cursor-pointer">
                                <label for="location_{{ $location->id }}" class="text-sm text-[var(--muted-foreground)] group-hover:text-[var(--foreground)] transition-colors cursor-pointer">
                                    {{ $location->display_name ?? $location->name ?? $location->ptero_id_location }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('locations') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 pt-6 border-t border-[var(--border)]">
                    <x-ui.button href="{{ route('admin.plans.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Créer le Plan</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection








