@props([
    'plans' => [],
    'stripePrices' => []
])

<div {{ $attributes->merge(['class' => 'relative group']) }}>
    <div id="plans-carousel" class="flex overflow-x-auto gap-4 no-scrollbar pt-6 pb-6 mx-auto mask-horizontal" style="max-width: 1400px;">
        @for($r = 0; $r < 3; $r++)
            @foreach($plans as $plan)
                <div class="flex-shrink-0 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.33%-1.25rem)] lg:w-[calc(25%-1.25rem)] min-w-[240px] max-w-[280px]">
                    <x-cards.pricing-card
                        :title="$plan->name"
                        :price="$stripePrices[$plan->id]['price'] ?? null"
                        :period="$stripePrices[$plan->id]['period'] ?? null"
                        :description="$plan->description"
                        :features="$plan->getFormattedFeatures()"
                        :isPopular="$loop->index === 1"
                    >
                        <div class="flex flex-col gap-2">
                            @auth
                                @php $canBuy = !empty($plan->price_stripe_id); @endphp
                                @if($canBuy)
                                    <form action="{{ route('billing.choose') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <x-ui.button type="submit" class="w-full justify-center font-bold" variant="accent">
                                            Choisir
                                        </x-ui.button>
                                    </form>
                                @else
                                    <x-ui.button href="{{ route('dashboard.index') }}" class="w-full justify-center font-bold" variant="accent">
                                        Mon Dashboard
                                    </x-ui.button>
                                @endif
                            @endauth
                            @guest
                                <x-ui.button href="{{ route('auth.register') }}" class="w-full justify-center font-bold" variant="accent">
                                    Commencer
                                </x-ui.button>
                            @endguest
                        </div>
                    </x-cards.pricing-card>
                </div>
            @endforeach

            @php
                $realPlansCount = $plans->count();
                $customCardsToAdd = max(1, 3 - $realPlansCount);
            @endphp

            @for($i = 0; $i < $customCardsToAdd; $i++)
                <div class="flex-shrink-0 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.33%-1.25rem)] lg:w-[calc(25%-1.25rem)] min-w-[240px] max-w-[280px]">
                    <x-cards.pricing-card
                        title="Sur mesure"
                        price="Sur devis"
                        description="Besoin d'une puissance supérieure ou d'une configuration spécifique ?"
                        :features="['Ressources illimitées', 'Support prioritaire 24/7', 'Infrastructure dédiée', 'SLA garanti']"
                        :isPopular="false"
                    >
                        <div class="flex flex-col gap-2">
                            <x-ui.button href="{{ route('contact', ['reason' => 'quote_request']) }}" class="w-full justify-center font-bold" variant="outline">
                                Contactez-nous
                            </x-ui.button>
                        </div>
                    </x-cards.pricing-card>
                </div>
            @endfor
        @endfor
    </div>

    <button id="carousel-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 size-12 rounded-full bg-[var(--control-background)] border border-[var(--border)] flex items-center justify-center text-muted-foreground hover:text-primary hover:border-primary transition-all opacity-0 group-hover:opacity-100 hidden md:flex shadow-xl" aria-label="Précédent">
        <x-heroicon-o-chevron-left class="size-6" />
    </button>
    <button id="carousel-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 size-12 rounded-full bg-[var(--control-background)] border border-[var(--border)] flex items-center justify-center text-muted-foreground hover:text-primary hover:border-primary transition-all opacity-0 group-hover:opacity-100 hidden md:flex shadow-xl" aria-label="Suivant">
        <x-heroicon-o-chevron-right class="size-6" />
    </button>
</div>
