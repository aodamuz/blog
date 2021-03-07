@props([
    'selected',
    'options' => [],
    'help' => null,
    'label' => null,
    'containerClass' => [],
    'placeholder' => null,
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
    <select {{ $attributes->merge([
        'id'    => $attributes->get('name'),
        'class' => implode(' ', $classList)
    ]) }}>
        @if ($placeholder)
            <option value="">{!! $placeholder !!}</option>
        @endif

        @foreach ($options as $key => $value)
            <option value="{{ $key }}"{{ $selected == $key ? ' selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</x-form-container>
