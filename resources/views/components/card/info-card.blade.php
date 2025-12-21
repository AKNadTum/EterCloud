@props([
    'variant' => 'default', // 'primary', 'accent', 'success', 'warning', 'destructive'
    'icon' => null,
    'title' => null,
    'description' => null,
])

@php
    $variantClasses = match($variant) {
        'primary' => 'card-primary',
        'accent' => 'card-accent',
        'success' => 'card-success',
        'warning' => 'card-warning',
        'destructive' => 'card-destructive',
        default => '',
    };
@endphp

<div {{ $attributes->merge(['class' => "bg-[var(--control-background)] border rounded-[var(--radius-lg)] p-8 group transition-all duration-300 $variantClasses"]) }}>
    @if($icon)
        <div @class([
            'size-12 rounded-2xl flex items-center justify-center mb-6 transition-transform shadow-sm',
            'bg-[var(--primary)] text-[var(--primary-foreground)]' => $variant === 'primary' || $variant === 'default',
            'bg-[var(--accent)] text-[var(--accent-foreground)]' => $variant === 'accent',
            'bg-[var(--success)] text-[var(--success-foreground)]' => $variant === 'success',
            'bg-[var(--warning)] text-[var(--warning-foreground)]' => $variant === 'warning',
            'bg-[var(--destructive)] text-[var(--destructive-foreground)]' => $variant === 'destructive',
        ])>
            <x-dynamic-component :component="$icon" class="size-6" />
        </div>
    @endif

    @if($title)
        <h3 class="text-lg font-bold mb-3">{{ $title }}</h3>
    @endif

    @if($description || !$slot->isEmpty())
        <div class="text-sm text-muted-foreground leading-relaxed">
            @if($description)
                {{ $description }}
            @endif
            {{ $slot }}
        </div>
    @endif
</div>
