@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'description' => null,
    'placeholder' => null,
])

<x-ui.forms.group :label="$label" :name="$name" :required="$required" :description="$description">
    <x-ui.input
        :id="$name"
        :name="$name"
        :type="$type"
        :value="old($name, $value)"
        :placeholder="$placeholder"
        :invalid="$errors->has($name)"
        {{ $attributes->whereDoesntStartWith(['label', 'name', 'type', 'value', 'required', 'description', 'placeholder']) }}
    />
</x-ui.forms.group>
