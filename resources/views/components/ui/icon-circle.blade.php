@props([
    'variant' => 'primary',
    'icon' => null,
    'size' => 'md',
])

@php
    $variants = [
        'primary' => 'bg-[var(--primary)] text-[var(--primary-foreground)] border-[var(--primary-foreground)]/10',
        'accent' => 'bg-[var(--accent)] text-[var(--accent-foreground)] border-[var(--accent-foreground)]/10',
        'success' => 'bg-[var(--success)] text-[var(--success-foreground)] border-[var(--success-foreground)]/10',
        'warning' => 'bg-[var(--warning)] text-[var(--warning-foreground)] border-[var(--warning-foreground)]/10',
        'destructive' => 'bg-[var(--destructive)] text-[var(--destructive-foreground)] border-[var(--destructive-foreground)]/10',
        'secondary' => 'bg-[var(--secondary)] text-[var(--secondary-foreground)] border-[var(--border)]',
    ];

    $sizes = [
        'xs' => 'size-6 p-1 rounded-lg',
        'sm' => 'size-8 p-1.5 rounded-lg',
        'md' => 'size-12 p-2.5 rounded-xl',
        'lg' => 'size-16 p-4 rounded-2xl',
    ];

    $iconSizes = [
        'xs' => 'size-3.5',
        'sm' => 'size-5',
        'md' => 'size-6',
        'lg' => 'size-10',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $iconSizeClass = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<div {{ $attributes->merge(['class' => "flex items-center justify-center border shadow-sm $variantClass $sizeClass"]) }}>
    @if($icon)
        <x-dynamic-component :component="$icon" class="{{ $iconSizeClass }}" />
    @else
        {{ $slot }}
    @endif
</div>




