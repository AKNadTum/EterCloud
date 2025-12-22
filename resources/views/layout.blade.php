<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name', 'EterCloud') }} - Hébergement Minecraft Gratuit & Alternative Aternos</title>
    <meta name="description" content="Découvrez EterCloud, le meilleur hébergement Minecraft gratuit. Une alternative à Aternos avec de vraies performances, sans file d'attente et sans lag.">
    <meta name="keywords" content="hébergement minecraft gratuit, alternative aternos, serveur minecraft gratuit performances, hébergeur minecraft, serveur minecraft gratuit">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <x-layout.header />

    <main class="min-h-screen">
        <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-8 pt-24">
            @if (session('success'))
                <x-ui.feedback.alert variant="success" dismissible="true" class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                    <x-heroicon-o-check-circle class="size-5" />
                    <x-ui.feedback.alert-description>
                        {{ session('success') }}
                    </x-ui.feedback.alert-description>
                </x-ui.feedback.alert>
            @endif

            @if (session('status'))
                <x-ui.feedback.alert variant="info" dismissible="true" class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                    <x-heroicon-o-information-circle class="size-5" />
                    <x-ui.feedback.alert-description>
                        {{ session('status') }}
                    </x-ui.feedback.alert-description>
                </x-ui.feedback.alert>
            @endif

            @if (session('error'))
                <x-ui.feedback.alert variant="error" dismissible="true" class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                    <x-heroicon-o-exclamation-circle class="size-5" />
                    <x-ui.feedback.alert-description>
                        {{ session('error') }}
                    </x-ui.feedback.alert-description>
                </x-ui.feedback.alert>
            @endif

            @if ($errors->any())
                <x-ui.feedback.alert variant="error" dismissible="true" class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                    <x-heroicon-o-x-circle class="size-5 shrink-0" />
                    <x-ui.feedback.alert-description>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-ui.feedback.alert-description>
                </x-ui.feedback.alert>
            @endif
        </div>

        @yield('content')
    </main>

    <x-layout.footer />
</body>
</html>




