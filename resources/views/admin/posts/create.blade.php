@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('admin/editor.css') }}"> --}}
@endpush

@push('after')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.0/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body', {
            filebrowserUploadUrl: "{{ route('admin.upload') }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

<x-admin-layout>
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('admin.posts.store') }}">
        @csrf

        <div class="lg:flex">
            <x-card class="lg:w-3/12 lg:ml-2 order-first lg:order-last mb-4">
                @can('setStatus', $post)
                    <x-form-select
                        name="status"
                        class="mb-4"
                        :label="__('Status')"
                        :selected="old('status', $post->present()->defaultStatus)"
                        :options="$post->present()->statuses"
                    />
                @endcan

                <x-form-select
                    name="category_id"
                    class="mb-4"
                    placeholder="&mdash;"
                    :label="__('Category')"
                    :selected="old('category_id')"
                    :options="$post->present()->categories"
                />

                @foreach ($post->present()->tags as $key => $tag)
                    <x-form-checkbox
                        name="tags[]"
                        label-class="text-sm"
                        :label="__($tag)"
                        :value="$key"
                    />
                @endforeach
            </x-card>

            <x-card class="lg:w-9/12 lg:mr-2 mb-4">
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
                    <textarea id="body" name="body" rows="10" cols="80">{{ old('body') }}</textarea>
                </div>

                <input type="submit" value="{{ __('Create Post') }}">
            </x-card>
        </div>
    </form>
</x-admin-layout>
