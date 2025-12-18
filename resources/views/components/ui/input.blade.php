@php
    $ariaInvalid = $invalid ? 'true' : null;
@endphp

<input
    type="{{ $type }}"
    @if($ariaInvalid) aria-invalid="true" @endif
    {{ $attributes->merge(['class' => $computedClasses]) }}
/>
