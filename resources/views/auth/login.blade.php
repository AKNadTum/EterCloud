<x-layout.auth title="Connexion" subtitle="Accédez à votre espace {{ config('app.name') }}">
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

    <form method="POST" action="{{ route('auth.login.submit') }}" class="space-y-6" novalidate>
        @csrf

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium">Adresse e‑mail</label>
            <x-ui.input id="email" name="email" type="email" autocomplete="email" placeholder="vous@exemple.com" required value="{{ old('email') }}" :invalid="$errors->has('email')" />
            @error('email')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-medium">Mot de passe</label>
                <a href="{{ route('password.request') }}" class="text-xs opacity-80 hover:opacity-100 text-link hover:text-link-hover transition">Mot de passe oublié ?</a>
            </div>
            <x-ui.input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" required :invalid="$errors->has('password')" />
            @error('password')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center gap-2 pt-1">
            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-input text-primary focus:ring-ring bg-background" />
            <label for="remember" class="text-sm cursor-pointer select-none">Se souvenir de moi</label>
        </div>

        <!-- Submit -->
        <x-ui.button type="submit" class="w-full justify-center font-semibold py-6" variant="primary">
            Se connecter
        </x-ui.button>
    </form>

    <x-slot:footer>
        <div class="text-center space-y-4">
            <p class="text-sm text-muted-foreground">
                Pas encore de compte ?
                <a href="{{ route('auth.register') }}" class="font-medium text-link hover:text-link-hover hover:underline underline-offset-4">Créer un compte</a>
            </p>
            <p>
                <a href="/" class="text-xs opacity-60 hover:opacity-100 transition-opacity">
                    &larr; Retour à l'accueil
                </a>
            </p>
        </div>
    </x-slot:footer>
</x-layout.auth>
