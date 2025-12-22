<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'EterCloud') }} · Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--background)] text-[var(--foreground)] antialiased">
    <main class="min-h-screen">
        <div class="mx-auto w-full px-4 md:px-6 lg:px-8 py-8" style="max-width: 1400px;">
            <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-8">
                <!-- Sidebar -->
                <div class="md:sticky md:top-8 self-start">
                    <x-layout.sidebar />
                </div>

                <!-- Main Content Area -->
                <div class="space-y-6">
                    <!-- Topbar / Breadcrumbs -->
                    <header class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm px-6 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl font-extrabold tracking-tight">
                                @yield('title', 'Tableau de bord')
                            </h1>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex items-center gap-3 glass px-4 py-1.5 rounded-full text-xs font-bold text-muted-foreground uppercase tracking-widest border-[var(--border)]/50">
                                <div class="size-2 rounded-full bg-[var(--success-foreground)]"></div>
                                {{ auth()->user()->name ?? auth()->user()->email }}
                            </div>
                            <x-ui.button href="{{ route('home') }}" variant="outline" size="sm" class="rounded-full">
                                <x-heroicon-o-home class="size-4 mr-1" />
                                Retour au site
                            </x-ui.button>
                        </div>
                    </header>

                    <div class="min-h-[60vh]">
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

                        @yield('dashboard')
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>




