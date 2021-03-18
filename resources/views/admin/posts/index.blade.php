<x-admin-layout>
	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
		{{ $posts->links() }}

		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					@include('admin.posts.table-cols')
				</thead>

				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($posts as $post)
						@include('admin.posts.table-row')
					@endforeach
				</tbody>

				<tfoot>
					@include('admin.posts.table-cols')
				</tfoot>
			</table>
		</div>

		{{ $posts->links() }}
	</div>
</x-admin-layout>
