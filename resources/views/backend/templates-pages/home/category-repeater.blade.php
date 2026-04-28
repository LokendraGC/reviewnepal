<div class="mb-3">
    <label for="social-media" class="form-label">Choose Category</label>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th class="custom-table-sno">S.No</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="addMoreItemTag">
                @isset($metaDatas['entertainment_cats'])
                    @php
                        $allTags = unserialize($metaDatas['entertainment_cats']);
                    @endphp
                    @foreach ($allTags as $index => $item)
                        <tr>
                            <td class="custom-table-no">{{ $loop->iteration }}
                            </td>
                            <td style="min-width: 300px;">
                                <input type="text" class="form-control"
                                    name="entertainment_cats[{{ $index }}][title]"
                                    value="{{ $item['title'] ?? '' }}" />
                            </td>
                            <td>
                                <select class="form-control select2" data-toggle="select2"
                                    name="entertainment_cats[{{ $index }}][category]"
                                    value="{{ $item['category'] ?? '' }}">
                                    <option selected disabled>Select</option>
                                    @foreach ($cats as $tag)
                                        <option @if ($item['category'] == $tag->id) selected @endif
                                            value="{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <a href="javascript: void(0);" class="text-reset fs-16 px-1 add_more_tag"><i
                                        class="bi bi-plus-circle"></i></a>
                                <a href="javascript: void(0);" class="text-reset fs-16 px-1 remove_tag"><i
                                        class="bi bi-x-circle"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="text-end mt-2">
            <button type="button" class="btn btn-primary btn-sm add_new_tag">Add
                New</button>
        </div>
    </div>
</div>


{{-- @push('backend-js') --}}
<script>
    // select2 reinitialize
    function selectReinitialize() {
        $('.select2').select2();
    }

    // tags
    // updateSerialNumbers
    function updateSerialNumbersTag() {
        $('.addMoreItemTag tr').each(function(index) {
            let newIndex = index;
            $(this).find('td:first').text(index + 1);
        });
    }
    // add new row
    function addRowDataTag() {
        let numberOfRow = $('.addMoreItemTag tr').length;
        let options = '';

        options = '<option value="none">Select</option>';
        @foreach (\App\Models\Category::where('type', 'category')->orderBy('name', 'ASC')->get() as $tag)
            options += `<option value="{{ $tag->id }}">{{ $tag->name }}</option>`;
        @endforeach

        let tr = `
            <tr>
                <td class="custom-table-no no">${numberOfRow + 1}</td>
                <td>
                    <input type="text" class="form-control" name="entertainment_cats[${numberOfRow + 1}][title]">
                </td>
                <td>
                    <select class="form-control select2" data-toggle="select2" name="entertainment_cats[${numberOfRow + 1}][category]>
                        ${options}
                    </select>
                </td>
                <td class="text-center">
                    <a href="javascript: void(0);" class="text-reset fs-16 px-1 add_more_tag"><i class="bi bi-plus-circle"></i></a>
                    <a href="javascript: void(0);" class="text-reset fs-16 px-1 remove_tag"><i class="bi bi-x-circle"></i></a>
                </td>
            </tr>
        `;

        return tr;
    }
    // click on add new button
    $(document).on('click', '.add_new_tag', function() {
        console.log('first')
        let row = addRowDataTag();
        $('.addMoreItemTag').append(row);
        selectReinitialize();
        updateSerialNumbersTag();
    });
    // click on icon
    $(document).on('click', '.add_more_tag', function() {
        let clickedRow = $(this).closest('tr');
        let row = addRowDataTag();
        clickedRow.after(row);
        selectReinitialize();
        updateSerialNumbersTag();
    });
    // click on remove
    $('.addMoreItemTag').delegate('.remove_tag', 'click', function() {
        $(this).parent().parent().remove();
        updateSerialNumbersTag();
    });
</script>
{{-- @endpush --}}
