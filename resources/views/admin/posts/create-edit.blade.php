@push('css')
	@if (config(ConfigKeys::CODE_BLOCK_IN_EDITOR_ENABLED, true))
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.12.0/katex.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.6.0/styles/monokai-sublime.min.css">
	@endif

	<link rel="stylesheet" href="/admin/editor.css">
@endpush

@push('after')
	@if (config(ConfigKeys::CODE_BLOCK_IN_EDITOR_ENABLED, true))
		<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.12.0/katex.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.6.0/highlight.min.js"></script>
	@endif

	<script src="/admin/editor.js"></script>

	<script>
		var quill = new Quill('#editor-container', {
			modules: {
				syntax: {{ config(ConfigKeys::CODE_BLOCK_IN_EDITOR_ENABLED, true) ? 'true' : 'false' }},
				toolbar: '#toolbar-container'
			},
			placeholder: '{{ __('Write the content of the publication here.') }}',
			theme: 'snow'
		});

		function setBody() {
			document.getElementById("body").value = document.querySelector('#editor-container').children[0].innerHTML;
		}
	</script>
@endpush

<x-admin-layout>
	<x-auth-validation-errors class="mb-4" :errors="$errors" />

	<form method="POST" action="{{ is_int($post->id) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" onsubmit="setBody()">
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
