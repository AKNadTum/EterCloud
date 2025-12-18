<x-layout.auth title="Créer un compte" subtitle="Rejoignez {{ config('app.name') }} en quelques secondes">
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

    <form method="POST" action="{{ route('auth.register.submit') }}" class="space-y-6" novalidate>
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="text-sm font-medium">Nom complet</label>
            <x-ui.input id="name" name="name" type="text" autocomplete="name" placeholder="Votre nom" required value="{{ old('name') }}" :invalid="$errors->has('name')" />
            @error('name')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

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
            <label for="password" class="text-sm font-medium">Mot de passe</label>
            <x-ui.input id="password" name="password" type="password" autocomplete="new-password" placeholder="••••••••" required :invalid="$errors->has('password')" />
            @error('password')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password confirmation -->
        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium">Confirmer le mot de passe</label>
            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="••••••••" required :invalid="$errors->has('password_confirmation')" />
            @error('password_confirmation')
                <p class="text-xs text-destructive-foreground mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms -->
        <div class="flex items-start gap-2 pt-1">
            <input id="terms" name="terms" type="checkbox" value="1" class="mt-1 h-4 w-4 rounded border-input text-primary focus:ring-ring bg-background" @checked(old('terms')) />
            <label for="terms" class="text-sm cursor-pointer select-none">
                J’accepte les <a href="{{ route('legal.tos') }}" class="font-medium underline underline-offset-4 hover:text-primary transition-colors">conditions d’utilisation</a> et la <a href="{{ route('legal.privacy') }}" class="font-medium underline underline-offset-4 hover:text-primary transition-colors">politique de confidentialité</a>
            </label>
        </div>

        <!-- Submit -->
        <x-ui.button type="submit" class="w-full justify-center font-semibold py-6" variant="primary">
            Créer un compte
        </x-ui.button>
    </form>

    <x-slot:footer>
        <div class="text-center space-y-4">
            <p class="text-sm text-muted-foreground">
                Vous avez déjà un compte ?
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
