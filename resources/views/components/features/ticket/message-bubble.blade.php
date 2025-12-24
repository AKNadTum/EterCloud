@props([
    'message',
    'isSupport' => false,
    'userName' => null,
    'date' => null,
])

<div {{ $attributes->merge(['class' => 'flex ' . ($isSupport ? 'justify-start' : 'justify-end')]) }}>
    <div class="max-w-[85%] {{ $isSupport ? 'bg-[var(--control-background)] border border-[var(--border)] text-[var(--foreground)]' : 'bg-[var(--accent)] text-[var(--accent-foreground)] border border-[var(--accent-foreground)]/20' }} rounded-2xl px-6 py-4 shadow-sm">
        <div class="flex items-center justify-between gap-4 mb-2">
            <span class="text-xs font-bold uppercase tracking-wider {{ $isSupport ? 'text-[var(--link)]' : 'text-[var(--accent-foreground)]' }}">
                {{ $isSupport ? 'Support EterCloud' : $userName }}
            </span>
            @if($date)
                <span class="text-[10px] {{ $isSupport ? 'text-[var(--muted-foreground)]' : 'text-[var(--accent-foreground)]/70' }}">
                    {{ $date }}
                </span>
            @endif
        </div>
        <div class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message }}</div>
    </div>
</div>
