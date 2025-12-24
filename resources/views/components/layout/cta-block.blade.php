@props([
    'title',
    'subtitle' => null,
    'buttonText' => 'Commencer',
    'buttonHref' => '#',
    'secondaryButtonText' => null,
    'secondaryButtonHref' => '#',
    'variant' => 'accent',
])

<x-ui.section {{ $attributes->merge(['class' => 'relative overflow-hidden']) }}>
    <div class="absolute inset-0 bg-gradient-to-t from-[var(--{{ $variant }})]/10 to-transparent -z-10"></div>
    <div class="bg-[var(--control-background)] border card-{{ $variant }} rounded-[var(--radius-xl)] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 size-64 bg-[var(--accent)]/20 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 size-64 bg-[var(--primary)]/20 blur-3xl rounded-full"></div>

        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4 leading-tight">
            {!! $title !!}
        </h2>

        @if($subtitle)
            <p class="text-base text-muted-foreground max-w-2xl mx-auto mb-8">
                {{ $subtitle }}
            </p>
        @endif

        <div class="flex flex-wrap items-center justify-center gap-3">
            <x-ui.button href="{{ $buttonHref }}" size="default" class="px-8 shadow-xl shadow-[var(--accent)]/20 font-bold">
                {{ $buttonText }}
            </x-ui.button>

            @if($secondaryButtonText)
                <x-ui.button href="{{ $secondaryButtonHref }}" variant="outline" size="default" class="px-8 font-bold bg-[var(--control-background)]/50 backdrop-blur-sm">
                    {{ $secondaryButtonText }}
                </x-ui.button>
            @endif
        </div>
    </div>
</x-ui.section>
