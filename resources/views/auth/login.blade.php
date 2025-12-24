<x-layout.auth title="Connexion" subtitle="Accédez à votre espace {{ config('app.name') }}">
    @if (session('status'))
        <x-ui.alert variant="info" dismissible="true" class="mb-4">

                {{ session('status') }}

        </x-ui.alert>
    @endif

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

    <form method="POST" action="{{ route('auth.login.submit') }}" class="space-y-6" novalidate>
        @csrf

        <!-- Email -->
        <x-ui.input label="Adresse e‑mail" id="email" name="email" type="email" autocomplete="email" placeholder="vous@exemple.com" required value="{{ old('email') }}" :invalid="$errors->has('email')" />

        <!-- Password -->
        <x-ui.input name="password" type="password" autocomplete="current-password" placeholder="••••••••" required :invalid="$errors->has('password')">
            <x-slot:label>
                <div class="flex items-center justify-between w-full">
                    <span class="text-sm font-medium">Mot de passe</span>
                    <a href="{{ route('password.request') }}" class="text-xs opacity-80 hover:opacity-100 text-link hover:text-link-hover transition">Mot de passe oublié ?</a>
                </div>
            </x-slot:label>
        </x-ui.input>

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








