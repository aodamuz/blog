@props([
    'options',
    'selected',
    'label' => null,
    'disabled' => false,
    'labelClass' => [],
    'placeholder' => null,
])

@php
    $classList = [
        'block',
        'w-full',
        'mt-1',
        'text-sm',
        'dark:text-gray-300',
        'dark:border-gray-600',
        'dark:bg-gray-700',
        'form-select',
        'focus:border-purple-400',
        'focus:outline-none',
        'focus:shadow-outline-purple',
        'dark:focus:shadow-outline-gray',
    ];
@endphp

<label class="{{ implode(' ', $labelClass) }}">
    @if (!empty($label))
        <span class="dark:text-gray-400 flex font-semibold items-center lg:w-5/12 text-gray-700">
            {{ $label }}
        </span>
    @endif

    <select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => implode(' ', $classList)]) }}>
        @if ($placeholder)
            <option value="">{!! $placeholder !!}</option>
        @endif

        @foreach ($options as $key => $value)
            <option value="{{ $key }}"{{ $selected == $key ? ' selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</label>
