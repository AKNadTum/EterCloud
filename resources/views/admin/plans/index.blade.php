@extends('admin.layout')

@section('title', 'Gestion des Plans')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Liste des plans</h2>
        <x-ui.button href="{{ route('admin.plans.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1" />
            Nouveau Plan
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Nom</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Stripe ID</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Configuration</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
        </x-slot>

        @foreach ($plans as $plan)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[var(--foreground)]">{{ $plan->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)] font-mono">{{ $plan->price_stripe_id }}</td>
                <td class="px-6 py-4">
                    <x-features.plan-feature-list :plan="$plan" class="!space-y-1" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <x-ui.button href="{{ route('admin.plans.edit', $plan) }}" variant="ghost" size="sm">
                        Modifier
                    </x-ui.button>
                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
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
                {{ $plans->links() }}
            </td>
        </x-slot>
    </x-ui.table>
@endsection










