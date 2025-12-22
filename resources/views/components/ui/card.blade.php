<div {{ $attributes->merge(['class' => 'bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden']) }}>
    @if($title || $description || isset($header))
        <div class="px-6 py-4 border-b border-[var(--border)]">
            @if(isset($header))
                {{ $header }}
            @else
                @if($title)
                    <h3 class="text-lg font-semibold text-[var(--foreground)]">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-[var(--muted-foreground)] mt-1">{{ $description }}</p>
                @endif
            @endif
        </div>
    @endif

    <div @class(['px-6 py-4' => $padded])>
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-6 py-4 bg-[var(--muted)] border-t border-[var(--border)]">
            {{ $footerSlot ?? $footer }}
        </div>
    @endif
</div>




