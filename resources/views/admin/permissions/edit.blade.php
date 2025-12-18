@extends('admin.layout')

@section('title', 'Modifier la Permission : ' . $permission->name)

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--foreground)] mb-1">Nom de la permission</label>
                    <x-ui.input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required :invalid="$errors->has('name')" placeholder="Ex: Supprimer un serveur" />
                    @error('name') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-[var(--foreground)] mb-1">Slug (identifiant unique)</label>
                    <x-ui.input type="text" name="slug" id="slug" value="{{ old('slug', $permission->slug) }}" required :invalid="$errors->has('slug')" placeholder="Ex: server.delete" />
                    @error('slug') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[var(--border)]">
                    <x-ui.button href="{{ route('admin.permissions.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Mettre à jour la Permission</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection
