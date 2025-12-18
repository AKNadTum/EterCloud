@extends('admin.layout')

@section('title', 'Gestion des Plans')

@section('content')
    <div class="mb-4 flex justify-end">
        <x-ui.button href="{{ route('admin.plans.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouveau Plan
        </x-ui.button>
    </div>
    <div class="bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-[var(--border)]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Mensuel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RAM / CPU / Disk</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-[var(--border)]">
                @foreach ($plans as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $plan->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($plan->price_monthly, 2) }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $plan->memory }} MB / {{ $plan->cpu }}% / {{ $plan->disk }} MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="text-[var(--primary)] hover:text-[var(--primary)]/80 mr-3">Modifier</a>
                            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
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
