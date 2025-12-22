<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label @if($name) for="{{ $name }}" @endif class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
            {{ $label }}
            @if($required)
                <span class="text-destructive">*</span>
            @endif
        </label>
    @endif

    <div class="space-y-1">
        {{ $slot }}

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




