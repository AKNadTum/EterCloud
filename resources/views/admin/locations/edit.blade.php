@extends('admin.layout')

@section('title', 'Modifier la Location')

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--foreground)] mb-1">Nom d'affichage (Local)</label>
                    <x-ui.input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required :invalid="$errors->has('name')" />
                    @error('name') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ptero_id_location" class="block text-sm font-medium text-[var(--foreground)] mb-1">Location Pterodactyl</label>
                    <select name="ptero_id_location" id="ptero_id_location" required class="w-full h-10 rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-3 text-sm text-[var(--control-foreground)] focus:outline-none focus:ring-2 focus:ring-[var(--ring)] focus:ring-offset-2 ring-offset-[var(--background)] transition-colors @error('ptero_id_location') border-[var(--destructive)] @enderror">
                        <option value="">Sélectionner une location</option>
                        @foreach($pteroLocations as $ptero)
                            <option value="{{ $ptero['attributes']['id'] }}" {{ old('ptero_id_location', $location->ptero_id_location) == $ptero['attributes']['id'] ? 'selected' : '' }}>
                                [{{ $ptero['attributes']['id'] }}] {{ $ptero['attributes']['short'] }} - {{ $ptero['attributes']['long'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('ptero_id_location') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[var(--border)]">
                    <x-ui.button href="{{ route('admin.locations.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Mettre à jour la Location</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection








