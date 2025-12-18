@extends('admin.layout')

@section('title', 'Modifier le Plan')

@section('content')
    <div class="bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="price_monthly" class="block text-sm font-medium text-gray-700">Prix Mensuel (€)</label>
                    <input type="number" step="0.01" name="price_monthly" id="price_monthly" value="{{ old('price_monthly', $plan->price_monthly) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="stripe_id" class="block text-sm font-medium text-gray-700">Stripe Price ID</label>
                    <input type="text" name="stripe_id" id="stripe_id" value="{{ old('stripe_id', $plan->stripe_id) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="cpu" class="block text-sm font-medium text-gray-700">CPU (%)</label>
                    <input type="number" name="cpu" id="cpu" value="{{ old('cpu', $plan->cpu) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="memory" class="block text-sm font-medium text-gray-700">Mémoire (MB)</label>
                    <input type="number" name="memory" id="memory" value="{{ old('memory', $plan->memory) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="disk" class="block text-sm font-medium text-gray-700">Disque (MB)</label>
                    <input type="number" name="disk" id="disk" value="{{ old('disk', $plan->disk) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div>
                    <label for="databases" class="block text-sm font-medium text-gray-700">Bases de données</label>
                    <input type="number" name="databases" id="databases" value="{{ old('databases', $plan->databases) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary)] focus:ring-[var(--primary)]">
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 pt-4">
                    <x-ui.button href="{{ route('admin.plans.index') }}" variant="outline">Annuler</x-ui.button>
                    <x-ui.button type="submit">Enregistrer</x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection
