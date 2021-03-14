@include('admin.posts.create-edit-scripts')

<x-admin-layout>
	<x-auth-validation-errors class="mb-4" :errors="$errors" />

	<form method="POST" action="{{ is_int($post->id) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" class="mb-6" onsubmit="setBody()">
		@csrf

		@if (is_int($post->id))
			@method('PUT')
		@endif

		<div class="grid grid-cols-8 gap-6">
			<x-card class="col-span-8 xl:col-span-2 order-first xl:order-last">
				@can('setStatus', $post)
					<x-form-select
						name="status"
						container-class="mb-4"
						:label="__('Status')"
						:selected="old('status', $post->status ?? $post->present()->defaultStatus)"
						:options="$post->present()->statuses"
					/>
				@endcan

				<x-form-select
					name="category_id"
					container-class="mb-4"
					placeholder="&mdash;"
					:label="__('Category')"
					:selected="old('category_id', $post->category_id)"
					:options="$post->present()->categories"
				/>

				<div class="mb-4 space-y-1">
					@foreach ($post->present()->tags as $key => $tag)
						<x-form-checkbox
							id="tag-{{ $key }}"
							name="tags[]"
							:checked="collect(old('tags', optional($post->tags)->pluck('id')))->contains($key)"
							:label="__($tag)"
							:value="$key"
						/>
					@endforeach
				</div>
			</x-card>

			<x-card class="col-span-8 xl:col-span-6">
				@include('admin.posts.form')

				<div class="mt-6 text-right">
					<x-button>Save</x-button>
				</div>
			</x-card>
		</div>
	</form>
</x-admin-layout>
