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
    $cardBase = 'group/card relative h-full rounded-[calc(var(--radius)*1.5)] border p-4 flex flex-col transition-all duration-500 hover:shadow-xl';

    if ($popular) {
        $cardClasses = "$cardBase card-accent shadow-2xl shadow-[var(--accent-foreground)]/10 ring-2 ring-[var(--accent-foreground)]/20 scale-[1.01] z-10";
    } else {
        $cardClasses = "$cardBase bg-[var(--control-background)] shadow-md hover:border-[var(--accent)]/40 hover:shadow-[var(--accent)]/10 z-0";
    }
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    {{-- Popular Badge --}}
    @if($popular)
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-full flex justify-center">
            <x-ui.feedback.badge variant="accent" size="sm" class="shadow-lg px-2 py-0.5 uppercase tracking-wider font-bold text-[9px]">
                ⭐ Recommandé
            </x-ui.feedback.badge>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="mb-4">
        <div class="flex items-start justify-between gap-2 mb-1.5 min-h-[2.5rem]">
            @if($title)
                <h3 class="text-sm font-bold tracking-tight {{ $popular ? 'text-[var(--accent-foreground)]' : 'text-foreground' }} transition-colors group-hover/card:text-[var(--accent-foreground)] line-clamp-2">
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
        <div class="min-h-[2rem] mb-2">
            @if($description)
                <p class="text-[11px] text-muted-foreground leading-relaxed line-clamp-2">{{ $description }}</p>
            @endif
        </div>

        {{-- Price Display --}}
        <div class="min-h-[2rem] flex flex-col justify-end">
            @if($price)
                <div class="flex items-baseline gap-1">
                    <span class="text-lg font-extrabold {{ $popular ? 'text-[var(--accent-foreground)]' : 'text-foreground' }}">{{ $price }}</span>
                    @if($period)
                        <span class="text-[10px] font-medium text-muted-foreground/80">/ {{ $period }}</span>
                    @endif
                </div>

                {{-- Right Meta below price if both exist --}}
                @if(!empty($rightMeta))
                    <div class="mt-0.5">
                        <span class="text-[9px] text-muted-foreground italic" title="{{ $rightMeta }}">
                            {{ $rightMeta }}
                        </span>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Features List --}}
    @if(!empty($features))
        <div class="flex-1 mb-4">
            <ul class="space-y-1.5">
                @foreach($features as $feature)
                    <li class="flex items-start gap-2 group/item">
                        <div class="mt-0.5 size-3.5 rounded-full bg-[var(--accent)]/10 flex items-center justify-center shrink-0 transition-colors group-hover/item:bg-[var(--accent)]/20">
                            <x-heroicon-o-check class="w-2.5 h-2.5 text-[var(--accent-foreground)]" aria-hidden="true" />
                        </div>
                        <span class="text-[11px] text-[var(--muted-foreground)] leading-snug transition-colors group-hover/item:text-[var(--foreground)]">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CTA Area --}}
    <div class="mt-auto pt-3">
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




