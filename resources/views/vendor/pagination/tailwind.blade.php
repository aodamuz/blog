@if ($paginator->hasPages())
	<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between px-4 py-3 text-xs font-semibold uppercase border-t bg-gray-50 dark:bg-gray-800">
		<div class="flex justify-between flex-1 lg:hidden">
			@if ($paginator->onFirstPage())
				<span class="opacity-30 relative inline-flex items-center px-4 py-2 font-medium border cursor-default leading-5 rounded-md">
					{!! __('pagination.previous') !!}
				</span>
			@else
				<a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 font-medium border leading-5 rounded-md focus:outline-none focus:ring ring-gray-300 dark:ring-primary-600 focus:border-primary-300 transition ease-in-out duration-150">
					{!! __('pagination.previous') !!}
				</a>
			@endif

			@if ($paginator->hasMorePages())
				<a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 font-medium border leading-5 rounded-md focus:outline-none focus:ring ring-gray-300 dark:ring-primary-600 focus:border-primary-300 transition ease-in-out duration-150 ml-3">
					{!! __('pagination.next') !!}
				</a>
			@else
				<span class="opacity-30 relative inline-flex items-center px-4 py-2 ml-3 font-medium border cursor-default leading-5 rounded-md">
					{!! __('pagination.next') !!}
				</span>
			@endif
		</div>

		<div class="hidden lg:flex-1 lg:flex lg:items-center lg:justify-between">
			<div>
				<p class="leading-5">
					{!! __('Showing') !!}
					<span class="font-medium inline-block mx-1">{{ $paginator->firstItem() }}</span>
					{!! __('to') !!}
					<span class="font-medium inline-block mx-1">{{ $paginator->lastItem() }}</span>
					{!! __('of') !!}
					<span class="font-medium inline-block mx-1">{{ $paginator->total() }}</span>
					{!! __('results') !!}
				</p>
			</div>

			<div>
				<span class="relative z-0 inline-flex shadow-sm rounded-md">
					{{-- Previous Page Link --}}
					@if ($paginator->onFirstPage())
						<span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
							<span class="opacity-30 relative inline-flex items-center p-2 font-medium border cursor-default rounded-l-md leading-5" aria-hidden="true">
								<x-icon type="prev" />
							</span>
						</span>
					@else
						<a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center p-2 font-medium border rounded-l-md leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 dark:ring-primary-600 focus:border-primary-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
							<x-icon type="prev" />
						</a>
					@endif

					{{-- Pagination Elements --}}
					@foreach ($elements as $element)
						{{-- "Three Dots" Separator --}}
						@if (is_string($element))
							<span aria-disabled="true">
								<span class="opacity-30 relative inline-flex items-center px-4 py-2 -ml-px font-medium border cursor-default leading-5">{{ $element }}</span>
							</span>
						@endif

						{{-- Array Of Links --}}
						@if (is_array($element))
							@foreach ($element as $page => $url)
								@if ($page == $paginator->currentPage())
									<span aria-current="page">
										<span class="relative inline-flex items-center px-4 py-2 -ml-px font-medium border cursor-default leading-5 ring ring-primary-500 border-primary-400">{{ $page }}</span>
									</span>
								@else
									<a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px font-medium border leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 dark:ring-primary-600 focus:border-primary-300 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
										{{ $page }}
									</a>
								@endif
							@endforeach
						@endif
					@endforeach

					{{-- Next Page Link --}}
					@if ($paginator->hasMorePages())
						<a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center p-2 -ml-px font-medium border rounded-r-md leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 dark:ring-primary-600 focus:border-primary-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
							<x-icon type="next" />
						</a>
					@else
						<span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
							<span class="opacity-30 relative inline-flex items-center p-2 -ml-px font-medium border cursor-default rounded-r-md leading-5" aria-hidden="true">
								<x-icon type="next" />
							</span>
						</span>
					@endif
				</span>
			</div>
		</div>
	</nav>
@endif
