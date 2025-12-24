<span {{ $attributes->merge(['class' => $computedClasses]) }}>
    {{ $status ? $getLabel() : $slot }}
</span>




