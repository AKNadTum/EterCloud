@extends('admin.layout')

@section('title', 'Gestion des Locations')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Liste des locations</h2>
        <x-ui.button href="{{ route('admin.locations.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouvelle Location
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Nom (Local)</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">ID Pterodactyl</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Code (Short)</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Description (Long)</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
        </x-slot>

        @foreach ($locations as $location)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[var(--foreground)]">{{ $location->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $location->ptero_id_location }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)] font-mono">{{ $location->ptero_short ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $location->ptero_long ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <x-ui.button href="{{ route('admin.locations.edit', $location) }}" variant="ghost" size="sm">
                        Modifier
                    </x-ui.button>
                    <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ? Cela ne supprimera que l\'entrée locale.')">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-900 hover:bg-red-50">
                            Supprimer
                        </x-ui.button>
                    </form>
                </td>
            </tr>
        @endforeach

        @if($locations->hasPages())
            <x-slot name="foot">
                <td colspan="5" class="px-6 py-4">
                    {{ $locations->links() }}
                </td>
            </x-slot>
        @endif
    </x-ui.table>
@endsection





