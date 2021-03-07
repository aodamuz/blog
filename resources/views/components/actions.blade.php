<div x-data="{ open: false }" @keydown.escape="open = false" @click.away="open = false" class="inline-block text-left">
	<a
		@click.prevent="open = !open"
		href="#"
		class="focus:outline-none font-medium inline-flex justify-center px-4 py-2 rounded-md text-sm w-full"
		id="options-menu"
		aria-haspopup="true"
		aria-expanded="true"
		x-bind:aria-expanded="open"
	>
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
		</svg>
	</a>

	<div
		x-show="open"
		x-description="Dropdown panel, show/hide based on dropdown state."
		x-transition:enter="transition ease-out duration-100"
		x-transition:enter-start="transform opacity-0 scale-95"
		x-transition:enter-end="transform opacity-100 scale-100"
		x-transition:leave="transition ease-in duration-75"
		x-transition:leave-start="transform opacity-100 scale-100"
		x-transition:leave-end="transform opacity-0 scale-95"
		class="absolute bg-white divide-gray-100 divide-y origin-top-right right-6 ring-1 ring-black ring-opacity-5 rounded-md shadow-lg w-56"
		role="menu"
		aria-orientation="vertical"
		aria-labelledby="options-menu"
	>
		<div class="py-1">
			<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Edit</a>
			<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Duplicate</a>
		</div>
	</div>
</div>
