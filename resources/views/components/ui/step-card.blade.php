@props([
    'step',
    'title',
    'description',
    'variant' => 'primary',
])

@php
    $variantClasses = [
        'primary' => 'card-primary',
        'accent' => 'card-accent',
        'success' => 'card-success',
        'warning' => 'card-warning',
    ];

    $badgeClasses = [
        'primary' => 'bg-[var(--primary)] text-[var(--primary-foreground)]',
        'accent' => 'bg-[var(--accent)] text-[var(--accent-foreground)]',
        'success' => 'bg-[var(--success)] text-[var(--success-foreground)]',
        'warning' => 'bg-[var(--warning)] text-[var(--warning-foreground)]',
    ];

    $class = $variantClasses[$variant] ?? $variantClasses['primary'];
    $badgeClass = $badgeClasses[$variant] ?? $badgeClasses['primary'];
@endphp

<div {{ $attributes->merge(['class' => "bg-[var(--control-background)] border $class rounded-[var(--radius-lg)] p-6 text-center transition-all duration-300 shadow-sm"]) }}>
    <div class="size-12 rounded-2xl {{ $badgeClass }} border border-white/10 flex items-center justify-center mx-auto mb-4 text-xl font-black shadow-sm">
        {{ $step }}
    </div>
    <h3 class="text-lg font-bold mb-2">{{ $title }}</h3>
    <p class="text-xs text-muted-foreground leading-relaxed">{{ $description }}</p>
</div>





