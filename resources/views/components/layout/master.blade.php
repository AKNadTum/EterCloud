@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ($title ? $title . ' - ' : '') . config('app.name', 'EterCloud') }} - Hébergement Minecraft Gratuit & Alternative Aternos</title>
    <meta name="description" content="{{ $description ?? 'Découvrez EterCloud, le meilleur hébergement Minecraft gratuit. Une alternative à Aternos avec de vraies performances, sans file d\'attente et sans lag.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'hébergement minecraft gratuit, alternative aternos, serveur minecraft gratuit performances, hébergeur minecraft, serveur minecraft gratuit' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body {{ $attributes->merge(['class' => 'antialiased']) }}>
    {{ $slot }}
    {{ $scripts ?? '' }}
</body>
</html>





