@extends('admin.layout')

@section('title', 'Gestion des Utilisateurs')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Liste des utilisateurs</h2>
        <x-ui.button href="{{ route('admin.users.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouvel Utilisateur
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rôle</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
        </x-slot>

        @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <x-user.avatar :user="$user" size="sm" />
                        <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    <x-ui.badge variant="subtle">
                        {{ $user->role?->name ?? 'Aucun' }}
                    </x-ui.badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <x-ui.button href="{{ route('admin.users.edit', $user) }}" variant="ghost" size="sm">
                        Modifier
                    </x-ui.button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-900 hover:bg-red-50">
                            Supprimer
                        </x-ui.button>
                    </form>
                </td>
            </tr>
        @endforeach

        <x-slot name="foot">
            <td colspan="4" class="px-6 py-4">
                {{ $users->links() }}
            </td>
        </x-slot>
    </x-ui.table>
@endsection
