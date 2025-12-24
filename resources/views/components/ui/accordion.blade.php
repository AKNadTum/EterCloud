@props(['items' => []])

<div {{ $attributes->merge(['class' => 'grid gap-3']) }}>
    @foreach($items as $item)
        <details class="group bg-[var(--control-background)] border {{ $item['variant'] ?? 'card-primary' }} rounded-[var(--radius-lg)] p-5 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
            <summary class="list-none font-bold text-base flex items-center justify-between">
                {{ $item['question'] }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-open:rotate-45">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </summary>
            <div class="mt-3 text-sm text-muted-foreground leading-relaxed border-t pt-3 border-foreground/10">
                {!! $item['answer'] !!}
            </div>
        </details>
    @endforeach
</div>




