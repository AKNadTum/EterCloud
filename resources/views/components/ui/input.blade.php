@php
    $ariaInvalid = $invalid ? 'true' : null;
@endphp

<div @if($label || $description || $name) class="space-y-2" @endif>
    @if($label)
        <label @if($name) for="{{ $name }}" @endif class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center gap-1">
            {{ $label }}
            @if($required)
                <span class="text-destructive">*</span>
            @endif
        </label>
    @endif

    <div class="space-y-1">
        @if($slot->isEmpty())
            <input
                type="{{ $type }}"
                @if($name) id="{{ $name }}" name="{{ $name }}" @endif
                @if($ariaInvalid) aria-invalid="true" @endif
                {{ $attributes->merge(['class' => $computedClasses]) }}
            />
        @else
            {{ $slot }}
        @endif

        @if($description)
            <p class="text-xs text-muted-foreground">{{ $description }}</p>
        @endif

        @if($name)
            @error($name)
                <p class="text-xs font-medium text-destructive">{{ $message }}</p>
            @enderror
        @endif

        @if($error)
            <p class="text-xs font-medium text-destructive">{{ $error }}</p>
        @endif
    </div>
</div>









