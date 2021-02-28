@props(['disabled' => false, 'labelClass' => null, 'label' => null])

@php
	$labelClass = !empty($labelClass) ? $labelClass : [];

	if (!is_array($labelClass)) {
		$labelClass = explode(' ', $labelClass);
	}

	$labelClass[] = 'flex';

	$classList = [
		'block',
		'dark:bg-gray-700',
		'dark:border-gray-600',
		'dark:focus:shadow-outline-gray',
		'dark:text-gray-300',
		'focus:border-purple-400',
		'focus:outline-none',
		'focus:shadow-outline-purple',
		'form-input',
		'lg:mt-0',
		'mt-1',
		'text-sm',
		'w-full',
	];
@endphp

<label class="{{ implode(' ', $labelClass) }}">
    @if (!empty($label))
        <span class="dark:text-gray-400 flex font-semibold items-center lg:w-5/12 text-gray-700">
        	{{ $label }}
        </span>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    	'placeholder' => $placeholder ?? $label ?? null,
        'class' => implode(' ', $classList),
    ]) !!}>
</label>
