@extends('admin.layout')

@section('title', 'Modifier l\'utilisateur')

@section('content')
    <div class="bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role_id" id="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <x-ui.button href="{{ route('admin.users.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Enregistrer</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection
