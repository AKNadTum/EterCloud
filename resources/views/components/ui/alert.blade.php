@php
    $title = $title ?? null;
    $dismissible = $dismissible ?? false;
@endphp

<div
    role="alert"
    @if($dismissible)
        id="alert-{{ $attributes->get('id', \Illuminate\Support\Str::random(8)) }}"
    @endif
    {{ $attributes->merge(['class' => $computedClasses . ($dismissible ? ' pr-10' : '')]) }}
>
    @if($title || isset($titleSlot))
        <h5 class="mb-1 font-medium leading-none tracking-tight">
            {{ $title ?? $titleSlot }}
        </h5>
    @endif

    {{ $slot }}

    @if($dismissible)
        <button
            type="button"
            onclick="this.parentElement.remove()"
            class="absolute right-4 top-4 rounded-md p-1 opacity-70 transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-[var(--ring)]"
            aria-label="Close"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    @endif
</div>





