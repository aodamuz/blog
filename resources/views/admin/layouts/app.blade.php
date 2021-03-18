<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>@yield('title', __('Dashboard')) - {{ config('app.name', 'Laravel') }}</title>

		@stack('head')

		{{-- <link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
			rel="stylesheet"
		/> --}}

		<link rel="stylesheet" href="{{ asset('admin/app.css') }}" />

		@stack('css')
	</head>
	<body x-data="data()" :class="{ dark }">
		<div x-cloak>
			@stack('before')

			<div
				class="flex h-screen bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200"
				:class="{ 'overflow-hidden': isSideMenuOpen }"
			>
				@include('admin.layouts.desktop-sidebar')
				{{-- @include('admin.layouts.mobile-sidebar') --}}

				<div class="flex flex-col flex-1 w-full">
					@include('admin.layouts.header')

					<main class="h-full overflow-y-auto">
						<div class="container px-6 mx-auto grid">
							<h2
								class="my-6 text-2xl font-semibold"
							>
								@yield('title', __('Dashboard'))
							</h2>

							@if ($msg = session('success'))
								<div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md mb-6" role="alert">
									<div class="flex items-center">
										<div class="py-1 mr-1">
											<x-icon type="check-circle"/>
										</div>

										<p class="text-sm">{{ $msg }}</p>
									</div>
								</div>
							@endif

							{{ $slot }}
						</div>
					</main>
				</div>
			</div>
		</div>

		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('admin/app.js') }}"></script>

		@stack('after')
	</body>
</html>
