@props([
    'plans' => [],
    'stripePrices' => []
])

<div {{ $attributes->merge(['class' => 'mx-auto w-full']) }} style="max-width: 1400px;">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
        @foreach($plans as $plan)
            <div class="w-full max-w-[320px]">
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
            <div class="w-full max-w-[320px]">
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
    </div>
</div>




