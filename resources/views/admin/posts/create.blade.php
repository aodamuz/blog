{{-- @push('css')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css">
	<link rel="stylesheet" href="{{ asset('admin/quill.css') }}">
@endpush

@push('after')
	<script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
	<script src="{{ asset('admin/quill.js') }}"></script>

	<script>
		var fonts = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
		var Font = Quill.import('formats/font');

		Font.whitelist = fonts;
		Quill.register(Font, true);

		var fullEditor = new Quill('#full-container .editor', {
			bounds: '#full-container .editor',
			modules: {
				'syntax': true,
				'toolbar': [
					[{ 'font': fonts }, { 'size': [] }],
					[ 'bold', 'italic', 'underline', 'strike' ],
					[{ 'color': [] }, { 'background': [] }],
					[{ 'script': 'super' }, { 'script': 'sub' }],
					[{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
					[{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
					[ {'direction': 'rtl'}, { 'align': [] }],
					[ 'link', 'image', 'video', 'formula' ],
					[ 'clean' ]
				],
			},
			theme: 'snow'
		});
	</script>
@endpush --}}

<x-admin-layout>
	<pre class="text-gray-500">
		{{ auth()->user()->can('create-posts') ? 'Yes' : 'No' }}
	</pre>
	<x-auth-validation-errors class="mb-4" :errors="$errors" />

	<form method="POST" action="{{ route('admin.posts.store') }}">
		@csrf

		<div class="lg:flex">
			<x-card class="lg:w-1/3 lg:ml-2 order-first lg:order-last">
				<select name="status">
					@foreach ($statuses as $key => $status)
						<option value="{{ $key }}"{{ old('status', $defaultStatus) == $key ? ' selected' : '' }}>{{ $status }}</option>
					@endforeach
				</select>
			</x-card>

			<x-card class="lg:w-2/3 lg:mr-2">
				<x-form-input
					name="title"
					:label="__('Title')"
					label-class="mb-4"
					value="{{ old('title') }}"
				/>

				<x-form-textarea
					name="description"
					rows="3"
					label-class="mb-4"
					:label="__('Description')"
				>
					{{ old('description') }}
				</x-form-textarea>

				<div class="mb-4">
					<textarea
						name="body"
						class="w-full form-textarea"
					>
						{{ old('body') }}
					</textarea>
				</div>

				<input type="submit" value="{{ __('Create Post') }}">
			</x-card>
		</div>
	</form>
</x-admin-layout>
