@props(['help' => null, 'name' => null, 'label' => null])

<div {{ $attributes->merge() }}>
    <label for="{{ $name ?? null }}" class="block text-sm font-medium">
        {{ $label }}
    </label>

    {{ $slot }}

    @isset($help)
        <div class="text-sm text-gray-500 bt-1">{{ $help }}</div>
    @endisset

    @error($name ?? null)
        <div class="text-sm text-red-500 bt-1">{{ $message }}</div>
    @enderror
</div>
