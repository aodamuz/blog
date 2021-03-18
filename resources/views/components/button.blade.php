@php
    $classList = [
        'bg-primary-600',
        'border',
        'border-transparent',
        'focus:outline-none',
        'focus:ring-2',
        'focus:ring-offset-2',
        'focus:ring-primary-500',
        'font-medium',
        'hover:bg-primary-700',
        'inline-flex',
        'justify-center',
        'px-4',
        'py-2',
        'rounded-md',
        'shadow-sm',
        'text-sm',
        'text-white',
    ];
@endphp

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => implode(' ', $classList)
]) }}>
    {{ $slot }}
</button>
