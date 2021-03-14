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
