@props([
	'label' => null,
	'containerClass' => null,
])

@php
	$id = $attributes->get('id', str_replace(['[', ']'], '', $attributes->get('name')));

	if (is_array($containerClass) || is_string($containerClass)) {
		$containerClass = is_string($containerClass) ? explode(' ', $containerClass) : $containerClass;
	} else {
		$containerClass = [];
	}

	$containerClass[] = 'flex';
	$containerClass[] = 'items-start';

	$classList = [
		'focus:ring-primary-500',
		'h-4',
		'rounded',
		'text-primary-600',
		'w-4',
	];
@endphp

<div class="{{ implode(' ', $containerClass) }}">
	<div class="flex items-center h-5">
		<input {{ $attributes->merge([
			'type'  => 'checkbox',
			'id'    => $id,
			'class' => implode(' ', $classList),
		]) }}>
	</div>

	<div class="ml-3 text-sm">
		<label for="{{ $id }}" class="block font-medium">{{ $label }}</label>

	    @isset($help)
	        <div class="text-sm text-gray-500 bt-1">{{ $help }}</div>
	    @endisset
	</div>
</div>
