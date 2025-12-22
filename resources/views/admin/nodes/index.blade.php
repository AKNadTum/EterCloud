@extends('admin.layout')

@section('title', 'Gestion des Nodes')

@section('content')
    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-[var(--secondary)]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">FQDN</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Mémoire</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Serveurs</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-[var(--control-background)] divide-y divide-[var(--border)]">
                @foreach ($nodes['data'] ?? [] as $node)
                    @php $attr = $node['attributes']; @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $attr['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[var(--foreground)]">{{ $attr['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $attr['fqdn'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">
                            {{ $attr['allocated_resources']['memory'] }} / {{ $attr['memory'] }} MB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">
                            @php
                                $servers = data_get($node, 'attributes.relationships.servers') ?? data_get($node, 'relationships.servers');
                                $count = data_get($servers, 'meta.pagination.total') ?? (is_array(data_get($servers, 'data')) ? count(data_get($servers, 'data')) : 0);
                            @endphp
                            {{ $count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.nodes.show', $attr['id']) }}" class="text-[var(--primary-foreground)] hover:underline">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection





