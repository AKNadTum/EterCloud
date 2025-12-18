@extends('admin.layout')

@section('title', 'Gestion des Rôles')

@section('content')
    <div class="mb-4 flex justify-end">
        <x-ui.button href="{{ route('admin.roles.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouveau Rôle
        </x-ui.button>
    </div>
    <div class="bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Permissions</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Utilisateurs</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-[var(--border)]">
                @foreach ($roles as $role)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $role->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $role->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $role->permissions_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $role->users_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-[var(--primary-foreground)] hover:underline mr-3">Modifier</a>
                            @if (!in_array($role->slug, ['admin', 'user']) && $role->users_count === 0)
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
