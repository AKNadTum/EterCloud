<x-layout.auth title="Vérification de l'e-mail" subtitle="Un lien de vérification vous a été envoyé.">
    @if (session('status') == 'verification-link-sent')
        <x-ui.alert variant="info" dismissible="true" class="mb-4">
            
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.
            
        </x-ui.alert>
    @endif

    <div class="text-sm text-muted-foreground mb-6">
        Avant de continuer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un autre avec plaisir.
    </div>

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-ui.button type="submit" variant="primary">
                Renvoyer l'e-mail de vérification
            </x-ui.button>
        </form>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <x-ui.button type="submit" variant="ghost">
                Se déconnecter
            </x-ui.button>
        </form>
    </div>
</x-layout.auth>









