@extends('admin.layout')

@section('title', 'Gestion des Permissions')

@section('content')
    <div class="mb-4 flex justify-end">
        <x-ui.button href="{{ route('admin.permissions.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouvelle Permission
        </x-ui.button>
    </div>
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-[var(--secondary)]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Rôles assignés</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-[var(--control-background)] divide-y divide-[var(--border)]">
                @foreach ($permissions as $permission)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[var(--foreground)]">{{ $permission->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $permission->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $permission->roles_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-[var(--primary-foreground)] hover:underline mr-3">Modifier</a>
                            @if ($permission->roles_count === 0)
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
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









