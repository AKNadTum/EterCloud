@extends('admin.layout')

@section('title', 'Modifier l\'utilisateur')

@section('content')
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <x-ui.card title="Modifier l'utilisateur" description="Mettez à jour les informations de compte de {{ $user->name }}." class="max-w-2xl">
            <div class="space-y-4">
                <x-ui.form.group label="Nom" name="name" required>
                    <x-ui.input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required :invalid="$errors->has('name')" />
                </x-ui.form.group>

                <x-ui.form.group label="Email" name="email" required>
                    <x-ui.input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required :invalid="$errors->has('email')" />
                </x-ui.form.group>

                <x-ui.form.group label="Rôle" name="role_id" required>
                    <select name="role_id" id="role_id" required class="w-full h-10 rounded-[var(--radius)] border border-[var(--border)] bg-white px-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[var(--ring)] focus:ring-offset-2 transition-colors @error('role_id') border-red-500 @enderror">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </x-ui.form.group>
            </div>

            <x-slot name="footerSlot">
                <div class="flex justify-end gap-3">
                    <x-ui.button href="{{ route('admin.users.index') }}" variant="outline">
                        Annuler
                    </x-ui.button>
                    <x-ui.button type="submit">
                        Enregistrer les modifications
                    </x-ui.button>
                </div>
            </x-slot>
        </x-ui.card>
    </form>
@endsection
