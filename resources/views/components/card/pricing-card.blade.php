@props([
    'title' => null,
    'price' => null,         // string|int|null
    'period' => null,        // ex: 'mois', 'an'
    'description' => null,
    'features' => [],        // array<string>
    'isPopular' => false,
    'ctaLabel' => 'Choisir',
    'ctaHref' => '#',
    'rightMeta' => null,     // string|null - texte à afficher à droite du titre (ex: "Tarif Stripe: ...")
])

@php
    $popular = (bool) ($isPopular ?? false);
    $cardBase = 'group relative h-full rounded-[calc(var(--radius)*1.5)] border p-6 flex flex-col transition-all duration-500 hover:shadow-xl';

    if ($popular) {
        $cardClasses = "$cardBase card-accent shadow-lg shadow-[var(--accent)]/10 ring-1 ring-[var(--accent)]/20";
    } else {
        $cardClasses = "$cardBase bg-[var(--control-background)] shadow-md hover:border-[var(--accent)]/40 hover:shadow-[var(--accent)]/10";
    }
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    {{-- Popular Badge --}}
    @if($popular)
        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
            <x-ui.badge variant="accent" size="sm" class="shadow-lg px-2 py-0.5 uppercase tracking-wider font-bold text-[10px]">
                ⭐ Recommandé
            </x-ui.badge>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="mb-5">
        <div class="flex items-start justify-between gap-2 mb-2 min-h-[3rem]">
            @if($title)
                <h3 class="text-lg font-bold tracking-tight text-foreground transition-colors group-hover:text-[var(--accent-foreground)] line-clamp-2">
                    {{ $title }}
                </h3>
            @endif

            {{-- Right Meta Badge (if no price) --}}
            @if(!empty($rightMeta) && !$price)
                <div class="shrink-0">
                    <span class="inline-block px-1.5 py-0.5 text-[10px] font-medium bg-[var(--secondary)] rounded-[var(--radius)] text-[var(--secondary-foreground)] max-w-[100px] truncate" title="{{ $rightMeta }}">
                        {{ $rightMeta }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="min-h-[2.5rem] mb-3">
            @if($description)
                <p class="text-xs text-muted-foreground leading-relaxed line-clamp-2">{{ $description }}</p>
            @endif
        </div>

        {{-- Price Display --}}
        <div class="min-h-[2.5rem] flex flex-col justify-end">
            @if($price)
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-extrabold text-foreground">{{ $price }}</span>
                    @if($period)
                        <span class="text-xs font-medium text-muted-foreground/80">/ {{ $period }}</span>
                    @endif
                </div>

                {{-- Right Meta below price if both exist --}}
                @if(!empty($rightMeta))
                    <div class="mt-1">
                        <span class="text-[10px] text-muted-foreground italic" title="{{ $rightMeta }}">
                            {{ $rightMeta }}
                        </span>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Features List --}}
    @if(!empty($features))
        <div class="flex-1 mb-6">
            <ul class="space-y-2">
                @foreach($features as $feature)
                    <li class="flex items-start gap-2 group/item">
                        <div class="mt-0.5 size-4 rounded-full bg-[var(--accent)]/10 flex items-center justify-center shrink-0 transition-colors group-hover/item:bg-[var(--accent)]/20">
                            <x-heroicon-o-check class="w-3 h-3 text-[var(--accent-foreground)]" aria-hidden="true" />
                        </div>
                        <span class="text-xs text-[var(--muted-foreground)] leading-snug transition-colors group-hover/item:text-[var(--foreground)]">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CTA Area --}}
    <div class="mt-auto pt-4">
        @if (! $slot->isEmpty())
            {{ $slot }}
        @else
            <x-ui.button
                href="{{ $ctaHref }}"
                class="w-full justify-center font-semibold"
                :variant="$popular ? 'accent' : 'outline'"
                :glow="$popular"
            >
                {{ $ctaLabel }}
            </x-ui.button>
        @endif
    </div>
</div>
