<div {{ $attributes->merge(['class' => 'bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm hover:shadow-md transition-shadow']) }}>
    <div class="flex items-center justify-between">
        <div @class(['size-12 rounded-lg flex items-center justify-center', $getColorClasses()])>
            <x-dynamic-component :component="$icon" class="size-6" />
        </div>
        @if($badgeText)
            <span @class(['text-xs font-bold px-2 py-1 rounded-full uppercase', $getColorClasses()])>
                {{ $badgeText }}
            </span>
        @endif
    </div>
    <div class="mt-4">
        <div class="text-sm font-medium text-[var(--muted-foreground)]">{{ $title }}</div>
        <div class="text-3xl font-bold text-[var(--foreground)] mt-1">{{ $value }}</div>
    </div>
    @if($href && $linkText)
        <div class="mt-4 pt-4 border-t border-[var(--border)]">
            <a href="{{ $href }}" @class(['text-sm font-semibold flex items-center hover:underline', str_contains($getColorClasses(), 'text-[var(--link)]') ? 'text-[var(--link)]' : (str_contains($getColorClasses(), 'text-purple-600') ? 'text-purple-600' : 'text-emerald-600')])>
                {{ $linkText }}
                <x-heroicon-o-arrow-right class="size-3 ml-1" />
            </a>
        </div>
    @endif
</div>

