@extends('admin.layout')

@section('title', 'Gestion des Serveurs')

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-[var(--secondary)]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Propriétaire</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Node</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-[var(--control-background)] divide-y divide-[var(--border)]">
                @foreach ($servers['data'] ?? [] as $server)
                    @php $attr = $server['attributes']; @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $attr['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[var(--foreground)]">{{ $attr['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">
                            {{ $attr['relationships']['user']['attributes']['username'] ?? $attr['user'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $attr['node'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.servers.show', $attr['id']) }}" class="text-[var(--primary-foreground)] hover:underline mr-3">Détails</a>
                            <form action="{{ route('admin.servers.destroy', $attr['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection









