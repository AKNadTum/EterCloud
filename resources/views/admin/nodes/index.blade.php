@extends('admin.layout')

@section('title', 'Gestion des Nodes')

@section('content')
    <div class="mb-4 flex justify-end">
        <x-ui.button href="{{ route('admin.nodes.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouveau Node
        </x-ui.button>
    </div>
    <div class="bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FQDN</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mémoire</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-[var(--border)]">
                @foreach ($nodes['data'] ?? [] as $node)
                    @php $attr = $node['attributes']; @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attr['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attr['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attr['fqdn'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attr['memory'] }} MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.nodes.show', $attr['id']) }}" class="text-[var(--primary)] hover:text-[var(--primary)]/80 mr-3">Détails</a>
                            <form action="{{ route('admin.nodes.destroy', $attr['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
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
