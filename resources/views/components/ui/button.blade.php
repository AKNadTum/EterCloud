@php
    $isLink = isset($href) && $href;
@endphp

@if($isLink)
    <a href="{{ $href }}" @if(!empty($target)) target="{{ $target }}" @endif @if(!empty($rel)) rel="{{ $rel }}" @endif {{ $attributes->merge(['class' => $computedClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $computedClasses]) }}>
        {{ $slot }}
    </button>
@endif
