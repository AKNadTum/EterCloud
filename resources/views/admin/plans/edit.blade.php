@extends('admin.layout')

@section('title', 'Modifier le Plan')

@section('content')
    <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
        @csrf
        @method('PUT')
        <x-ui.card title="Modifier le Plan" description="Configurez les ressources et les limites du plan {{ $plan->name }}." class="max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-ui.form.group label="Nom du Plan" name="name" required>
                        <x-ui.input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required :invalid="$errors->has('name')" />
                    </x-ui.form.group>
                </div>

                <div class="md:col-span-2">
                    <x-ui.form.group label="Description" name="description">
                        <textarea name="description" id="description" rows="3" class="w-full rounded-[var(--radius)] border border-[var(--border)] bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[var(--ring)] focus:ring-offset-2 transition-colors @error('description') border-red-500 @enderror">{{ old('description', $plan->description) }}</textarea>
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Stripe Price ID" name="price_stripe_id" required description="{{ $stripeDetails ? 'Prix actuel sur Stripe : ' . $stripeDetails['price'] . ' / ' . $stripeDetails['period'] : null }}">
                        <x-ui.input type="text" name="price_stripe_id" id="price_stripe_id" value="{{ old('price_stripe_id', $plan->price_stripe_id) }}" required :invalid="$errors->has('price_stripe_id')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Limite de Serveurs" name="server_limit" required>
                        <x-ui.input type="number" name="server_limit" id="server_limit" value="{{ old('server_limit', $plan->server_limit) }}" required :invalid="$errors->has('server_limit')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="CPU (%) (0 = illimité)" name="cpu" required>
                        <x-ui.input type="number" name="cpu" id="cpu" value="{{ old('cpu', $plan->cpu) }}" required :invalid="$errors->has('cpu')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Mémoire (MB) (0 = illimitée)" name="memory" required>
                        <x-ui.input type="number" name="memory" id="memory" value="{{ old('memory', $plan->memory) }}" required :invalid="$errors->has('memory')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Disque (MB)" name="disk" required>
                        <x-ui.input type="number" name="disk" id="disk" value="{{ old('disk', $plan->disk) }}" required :invalid="$errors->has('disk')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Limite Bases de données" name="databases_limit" required>
                        <x-ui.input type="number" name="databases_limit" id="databases_limit" value="{{ old('databases_limit', $plan->databases_limit) }}" required :invalid="$errors->has('databases_limit')" />
                    </x-ui.form.group>
                </div>

                <div>
                    <x-ui.form.group label="Limite Backups" name="backups_limit" required>
                        <x-ui.input type="number" name="backups_limit" id="backups_limit" value="{{ old('backups_limit', $plan->backups_limit) }}" required :invalid="$errors->has('backups_limit')" />
                    </x-ui.form.group>
                </div>

                <div class="md:col-span-2 border-t border-[var(--border)] pt-4">
                    <x-ui.form.group label="Localisations autorisées" name="locations">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($locations as $location)
                                <label class="flex items-center gap-2 group cursor-pointer">
                                    <input type="checkbox" name="locations[]" value="{{ $location->id }}"
                                        {{ in_array($location->id, old('locations', $plan->locations->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="size-4 rounded border-[var(--border)] text-[var(--primary)] focus:ring-[var(--ring)] transition-colors cursor-pointer">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                        {{ $location->display_name ?? $location->name ?? $location->ptero_id_location }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </x-ui.form.group>
                </div>
            </div>

            <x-slot name="footerSlot">
                <div class="flex justify-end gap-3">
                    <x-ui.button href="{{ route('admin.plans.index') }}" variant="outline">
                        Annuler
                    </x-ui.button>
                    <x-ui.button type="submit">
                        Enregistrer les modifications
                    </x-ui.button>
                </div>
            </x-slot>
        </x-ui.card>
    </form>
@endsection
