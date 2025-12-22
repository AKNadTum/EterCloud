@props(['title', 'subtitle' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — {{ config('app.name', 'Etercloud') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-background text-foreground antialiased selection:bg-primary/30">
    <div class="relative min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <!-- Background decorative elements -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-primary/10 blur-[120px]"></div>
            <div class="absolute top-[20%] right-[5%] h-[30%] w-[30%] rounded-full bg-accent/5 blur-[100px]"></div>
            <div class="absolute -bottom-[10%] left-[20%] h-[35%] w-[35%] rounded-full bg-primary/5 blur-[110px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-accent/10 blur-[120px]"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center mb-6">
                <a href="/" class="group flex items-center gap-3 transition-transform hover:scale-105">
                     <div class="size-12 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:shadow-primary/30 transition-shadow">
                        <x-heroicon-s-cloud class="size-7 text-primary-foreground" />
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-foreground">{{ config('app.name') }}</span>
                </a>
            </div>

            @if(isset($header))
                {{ $header }}
            @else
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-semibold tracking-tight">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="mt-2 text-sm text-muted-foreground">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="glass-card p-8 sm:p-10">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="mt-8">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>




