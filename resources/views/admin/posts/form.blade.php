<div class="grid grid-cols-6 gap-6">
	<x-form-input :label="__('Title')" name="title" :value="old('title', $post->title)" container-class="col-span-6 lg:col-span-5" autofocus/>

	@if ($post->id)
		<x-form-input :label="__('URL')" name="slug" :value="old('slug', $post->slug)" container-class="col-span-6 lg:col-span-5"/>
	@endif

	<x-form-textarea :label="__('Description')" name="description" :value="old('description', $post->description)" rows="5" container-class="col-span-6 lg:col-span-5"/>

	<input type="hidden" id="body" name="body" value="{{ old('body', $post->body) }}" />

	<div class="col-span-6">
		<div id="standalone-container">
			<div id="toolbar-container">
				<span class="ql-formats">
					<select class="ql-font"></select>
					<select class="ql-size"></select>
				</span>

				<span class="ql-formats">
					<button class="ql-bold"></button>
					<button class="ql-italic"></button>
					<button class="ql-underline"></button>
					<button class="ql-strike"></button>
				</span>

				<span class="ql-formats">
					<select class="ql-color"></select>
					<select class="ql-background"></select>
				</span>

				<span class="ql-formats">
					<button class="ql-script" value="sub"></button>
					<button class="ql-script" value="super"></button>
				</span>

				<span class="ql-formats">
					<button class="ql-header" value="1"></button>
					<button class="ql-header" value="2"></button>
					<button class="ql-blockquote"></button>
					@if (config(ConfigKeys::CODE_BLOCK_IN_EDITOR_ENABLED, true))
						<button class="ql-code-block"></button>
					@endif
				</span>

				<span class="ql-formats">
					<button class="ql-list" value="ordered"></button>
					<button class="ql-list" value="bullet"></button>
					<button class="ql-indent" value="-1"></button>
					<button class="ql-indent" value="+1"></button>
				</span>

				<span class="ql-formats">
					<button class="ql-direction" value="rtl"></button>
					<select class="ql-align"></select>
				</span>

				<span class="ql-formats">
					<button class="ql-link"></button>
					<button class="ql-image"></button>
					<button class="ql-video"></button>
					<button class="ql-formula"></button>
				</span>

				<span class="ql-formats">
					<button class="ql-clean"></button>
				</span>
			</div>

			<div id="editor-container">{!! old('body', $post->body) !!}</div>
		</div>
	</div>
</div>
