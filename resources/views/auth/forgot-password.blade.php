<x-layout.auth title="Mot de passe oublié" subtitle="Entrez votre adresse e‑mail et nous vous enverrons un lien de réinitialisation.">
    @if (session('status'))
        <x-ui.alert variant="info" dismissible="true" class="mb-4">
            <x-ui.alert-description>
                {{ session('status') }}
            </x-ui.alert-description>
        </x-ui.alert>
    @endif

    @if ($errors->any())
        <x-ui.alert variant="error" dismissible="true" class="mb-6">
            <x-heroicon-s-x-circle class="size-5 shrink-0" />
            <x-ui.alert-description>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert-description>
        </x-ui.alert>
    @endif

    <form method="POST" action="{{ route('auth.password.email') }}" class="space-y-6" novalidate>
        @csrf

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium">Adresse e‑mail</label>
            <x-ui.input id="email" name="email" type="email" autocomplete="email" placeholder="vous@exemple.com" required :invalid="$errors->has('email')" />
            @error('email')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <x-ui.button type="submit" class="w-full justify-center font-semibold py-6" variant="primary">
            Envoyer le lien de réinitialisation
        </x-ui.button>
    </form>

    <x-slot:footer>
        <div class="text-center space-y-4">
            <p class="text-sm text-muted-foreground">
                Vous vous souvenez de votre mot de passe ?
                <a href="{{ route('auth.login') }}" class="font-medium text-link hover:text-link-hover hover:underline underline-offset-4">Se connecter</a>
            </p>
            <p>
                <a href="/" class="text-xs opacity-60 hover:opacity-100 transition-opacity">
                    &larr; Retour à l'accueil
                </a>
            </p>
        </div>
    </x-slot:footer>
</x-layout.auth>
