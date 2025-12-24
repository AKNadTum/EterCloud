<x-layout.auth title="Réinitialiser le mot de passe" subtitle="Choisissez votre nouveau mot de passe">
    @if ($errors->any())
        <x-ui.alert variant="error" dismissible="true" class="mb-6">
            <x-heroicon-s-x-circle class="size-5 shrink-0" />
            
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            
        </x-ui.alert>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium">Adresse e-mail</label>
            <x-ui.input id="email" name="email" type="email" autocomplete="email" placeholder="vous@exemple.com" required value="{{ old('email') }}" :invalid="$errors->has('email')" />
            @error('email')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="text-sm font-medium">Nouveau mot de passe</label>
            <x-ui.input id="password" name="password" type="password" autocomplete="new-password" placeholder="••••••••" required :invalid="$errors->has('password')" />
            @error('password')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium">Confirmer le mot de passe</label>
            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="••••••••" required />
        </div>

        <!-- Submit -->
        <x-ui.button type="submit" class="w-full justify-center font-semibold py-6" variant="primary">
            Réinitialiser le mot de passe
        </x-ui.button>
    </form>
</x-layout.auth>








