@extends('admin.layout')

@section('title', 'Modifier le Rôle : ' . $role->name)

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-4xl">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--foreground)] mb-1">Nom du rôle</label>
                    <x-ui.input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required :invalid="$errors->has('name')" placeholder="Ex: Modérateur" />
                    @error('name') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <h3 class="text-sm font-medium text-[var(--foreground)] mb-3">Permissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($permissions as $permission)
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}" class="focus:ring-[var(--ring)] h-4 w-4 text-[var(--primary)] border-[var(--border)] rounded" {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="permission_{{ $permission->id }}" class="font-medium text-[var(--foreground)]">{{ $permission->name }}</label>
                                    <p class="text-[var(--muted-foreground)] text-xs">{{ $permission->slug }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions') <p class="mt-1 text-sm text-[var(--destructive-foreground)]">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[var(--border)]">
                    <x-ui.button href="{{ route('admin.roles.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Mettre à jour le Rôle</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection
