<div class="card">
    <div class="card-body">
        <div class="mb-2 d-flex align-content-center border-1 border-bottom">
            <h4 class="header-title">
                {{ $title }}
                {{-- @if ($required) --}}
                {{-- <span class="text-danger">*</span> --}}
                {{-- @endif --}}
            </h4>
        </div>
        <div class="cat-lists mt-2 {{ $custom ?? '' }}">
            <select class="select2 form-control {{ $type == 'single' ? 'single' : 'select2-multiple' }}"
                data-toggle="select2" {{ $type == 'single' ? '' : 'multiple = "multiple"' }} name="{{ $name }}">
                @if ($type == 'single')
                <option>None</option>
                @endif
                @foreach ($authors as $author)
                @if ($post)
                <option value="{{ $author->id }}" @if ($post->categories->contains('id', $author->id)) selected @endif>
                    {{ CategoryHelper::get_field('name_ne', $author) }}
                </option>
                @else
                <option value="{{ $author->id }}">{{ CategoryHelper::get_field('name_ne', $author) }}</option>
                @endif
                @endforeach
            </select>
            @error(preg_replace('/[\[\]]/', '', $name))
            <div class="valid-feedback d-block text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>