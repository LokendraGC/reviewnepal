<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="title">{{ $titleLabel ?? 'Title' }} <span
                    class="text-danger">*</span></label>
            <input name="post_name" type="text" id="title" placeholder="{{ $placeholder }}"
                value="{{ $title ?? old('post_name') }}" required class="form-control" />
            @error('post_name')
                <div class="valid-feedback d-block text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if (request()->segment(3) != 'contestant')
            <div class="mb-3">
                <label class="form-label" for="slug">Slug</label>
                <input name="slug" id="slug" type="text" class="form-control" value="{{ $slug }}" />
                <span class="form-text text-muted">
                    <small>The “slug” is the URL-friendly version of the name. It is usually all
                        lower case and contains only letters, numbers, and hyphens
                        (optional).</small>
                </span>
                @error('slug')
                    <div class="invalid-feedback d-block text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif
        @if (request()->segment(2) != 'web-stories')
            <div class="mb-3">
                <label for="content" class="form-label">Description</label>
                <textarea class="editor" id="content" name="post_content">{{ $content ?? old('post_content') }}</textarea>
            </div>
        @endif
    </div>
</div>
