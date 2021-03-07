@props([
    'help' => null,
    'label' => null,
    'value' => null,
    'containerClass' => [],
])

@php
    if (is_array($containerClass) || is_string($containerClass)) {
        $containerClass = is_string($containerClass) ? explode(' ', $containerClass) : $containerClass;
    } else {
        $containerClass = [];
    }

    $classList = [
        'bg-white',
        'block',
        'dark:bg-gray-700',
        'dark:border-gray-600',
        'dark:focus:ring-gray-400',
        'dark:text-gray-300',
        'focus:border-primary-500',
        'focus:outline-none',
        'focus:ring-primary-500',
        'mt-1',
        'px-3',
        'py-2',
        'rounded-md',
        'shadow-sm',
        'sm:text-sm',
        'w-full',
    ];
@endphp

<x-form-container :help="$help" :name="$attributes->get('name')" :label="$label" class="{{ implode(' ', $containerClass) }}">
    <textarea {{ $attributes->merge([
        'id'    => $attributes->get('name'),
        'class' => implode(' ', $classList)
    ]) }}>{{ $value ?? $slot }}</textarea>
</x-form-container>
