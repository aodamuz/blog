@props([
    'label' => null,
    'disabled' => false,
    'labelClass' => null,
])

@php
    if (is_array($labelClass) || is_string($labelClass)) {
        $labelClass = is_string($labelClass) ? explode(' ', $labelClass) : $labelClass;
    } else {
        $labelClass = [];
    }

    $labelClass[] = 'flex';
    $labelClass[] = 'items-center';
    $labelClass[] = 'dark:text-gray-400';

    $classList = [
        'dark:focus:shadow-outline-gray',
        'focus:border-purple-400',
        'focus:outline-none',
        'focus:shadow-outline-purple',
        'form-checkbox',
        'text-purple-600',
    ];
@endphp

<label class="{{ implode(' ', $labelClass) }}">
    <input type="checkbox" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => implode(' ', $classList)]) }}>

    @if (!empty($label))
    <span class="ml-2">
        {{ $label }}
    </span>
    @endif
</label>
