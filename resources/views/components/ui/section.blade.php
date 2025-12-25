@props([
    'title' => null,
    'subtitle' => null,
    'container' => true,
    'containerClass' => ''
])

<section {{ $attributes->merge(['class' => 'py-12 md:py-16']) }}>
    @if($container)
        <x-layout.container class="{{ $containerClass }}">
            @if($title || $subtitle)
                <div class="mb-8 text-center">
                    @if($title)
                        <h2 class="text-2xl font-bold tracking-tight">{{ $title }}</h2>
                    @endif
                    @if($subtitle)
                        <p class="mt-2 text-sm text-muted-foreground">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
            {{ $slot }}
        </x-layout.container>
    @else
        @if($title || $subtitle)
            <div class="mb-8 text-center px-4">
                @if($title)
                    <h2 class="text-2xl font-bold tracking-tight">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="mt-2 text-sm text-muted-foreground">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        {{ $slot }}
    @endif
</section>





