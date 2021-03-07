<x-admin-layout>
	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					<tr class="bg-gray-50 border-b dark:bg-gray-700 font-semibold text-left text-xs tracking-wide uppercase">
						<th class="px-4 py-3">{{ __('Title') }}</th>
						<th class="px-4 py-3">{{ __('Status') }}</th>
						<th class="px-4 py-3">{{ __('Author') }}</th>
						<th class="px-4 py-3">{{ __('Category') }}</th>
						<th class="px-4 py-3">{{ __('Created At') }}</th>
						<th class="px-4 py-3">{{ __('Actions') }}</th>
					</tr>
				</thead>

				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($posts as $post)
						<tr class="text-gray-700 dark:text-gray-400">
							<td class="px-4 py-3">
								<div class="flex items-center text-sm">
									<div class="relative hidden w-8 h-8 mr-3 md:block">
										<img
											src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
											class="object-cover w-full h-full"
											alt=""
											loading="lazy"
										/>

										<div class="absolute inset-0 shadow-inner" aria-hidden="true"></div>
									</div>

									<div>
										<p class="font-semibold">{{ $post->title }}</p>
										<p class="text-xs text-gray-600 dark:text-gray-400">
											{{ Str::limit($post->description, 25) }}
										</p>
									</div>
								</div>
							</td>

							<td class="px-4 py-3 text-xs">
								<span class="font-semibold inline-flex items-center leading-tight px-2 py-1 rounded-full {{ $post->present()->statusClass }}">
									{{ __(ucfirst($post->status)) }}
								</span>
							</td>

							<td class="px-4 py-3 text-sm">
								{{ $post->user->name }}
							</td>

							<td class="px-4 py-3 text-sm">
								<span title="{{ optional($post->category)->title ?? __('Uncategorized') }}">
									{{ Str::limit(optional($post->category)->title ?? __('Uncategorized'), 15) }}
								</span>
							</td>

							<td class="px-4 py-3 text-sm">
								{{ $post->created_at->format('F j, Y - g:i a') }}
							</td>

							<td class="px-4 py-3">
								<x-actions></x-actions>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-gray-50 border-t dark:bg-gray-700 font-semibold text-left text-xs tracking-wide uppercase">
						<th class="px-4 py-3">{{ __('Title') }}</th>
						<th class="px-4 py-3">{{ __('Status') }}</th>
						<th class="px-4 py-3">{{ __('Author') }}</th>
						<th class="px-4 py-3">{{ __('Category') }}</th>
						<th class="px-4 py-3">{{ __('Created At') }}</th>
						<th class="px-4 py-3">{{ __('Actions') }}</th>
					</tr>
				</tfoot>
			</table>
		</div>

		{{ $posts->links() }}
	</div>
</x-admin-layout>
