<tr class="text-gray-700 dark:text-gray-400">
	<td class="px-4 py-3">
		<div class="flex items-center text-sm">
			<div class="relative hidden w-8 h-8 mr-3 lg:block">
				<img
					src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
					class="object-cover w-full h-full"
					alt=""
					loading="lazy"
				/>

				<div class="absolute inset-0 shadow-inner" aria-hidden="true"></div>
			</div>

			<div class="flex-auto">
				<div class="font-semibold">
					@can('update', $post)
						<a href="{{ route('admin.posts.edit', $post) }}" class="hover:underline text-primary-600 dark:text-primary-400">
							{{ $post->title }}
						</a>
					@else
						<p>{{ $post->title }}</p>
					@endcan
				</div>

				<div class="flex items-center space-between text-xs transition-all space-x-1">
					@can('update', $post)
						<a
							href="{{ route('admin.posts.edit', $post) }}"
							class="inline-block underline hover:no-underline hover:text-primary-600 dark:hover:text-primary-400"
						>{{ __('Edit') }}</a>
					@endcan

					@can('restore', $post)
						<form action="{{ route('admin.posts.restore', $post) }}" method="POST" class="inline-block">
							@csrf @method('PATCH')

							<button
								type="submit"
								onclick="return confirm('{{ __(Messages::POST_RESTORE) }}');"
								class="inline-block underline hover:no-underline bg-transparent border-0 p-0 focus:outline-none hover:text-primary-600 dark:hover:text-primary-400"
							>{{ __('Restore') }}</button>
						</form>
					@endcan

					@can('delete', $post)
						<form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block">
							@csrf @method('DELETE')

							<button
								type="submit"
								onclick="return confirm('{{ __(Messages::POST_SEND_TO_TRASH) }}');"
								class="inline-block underline hover:no-underline bg-transparent border-0 p-0 focus:outline-none hover:text-primary-600 dark:hover:text-primary-400"
							>{{ __('Send to Trash') }}</button>
						</form>
					@endcan

					@can('forceDelete', $post)
						<form action="{{ route('admin.posts.delete', $post) }}" method="POST" class="inline-block">
							@csrf @method('DELETE')

							<button
								type="submit"
								onclick="return confirm('{{ __(Messages::POST_DELETE) }}');"
								class="inline-block underline hover:no-underline bg-transparent border-0 p-0 focus:outline-none hover:text-primary-600 dark:hover:text-primary-400"
							>{{ __('Delete') }}</button>
						</form>
					@endcan
				</div>
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

	<td class="px-4 py-3 text-sm hidden lg:table-cell">
		<span title="{{ optional($post->category)->title ?? __('Uncategorized') }}">
			{{ Str::limit(optional($post->category)->title ?? __('Uncategorized'), 15) }}
		</span>
	</td>

	<td class="px-4 py-3 text-sm hidden lg:table-cell">
		{{ $post->created_at->format('F j, Y - g:i a') }}
	</td>
</tr>
