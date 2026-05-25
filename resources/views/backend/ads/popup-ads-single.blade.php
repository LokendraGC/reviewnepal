<div class="tab-pane fade {{ request()->query('tab') == 'popup-ads-single' ? 'active show' : '' }}" id="popup-ads-single"
    role="tabpanel" aria-labelledby="popup-ads-single-tab">

    <div class="row">
        <div class="col-md-12">

            <div
                class="mb-3 d-flex align-items-center justify-content-between border rounded-3 px-3 py-3 bg-light-subtle">
                <div>
                    <label for="show_popup_on_single" class="form-label fw-semibold mb-1">Show Popup Ads </label>
                    <p class="text-muted mb-0 small">Enable this to display the popup.</p>
                </div>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" id="show_popup_on_single" name="show_popup_on_single" value="1"
                        {{ isset($settings['show_popup_on_single']) && $settings['show_popup_on_single'] == 1 ? 'checked' : '' }}
                        style="width: 3rem; height: 1.5rem; cursor: pointer;" />
                </div>
            </div>

             <div
                class="mb-3 d-flex align-items-center justify-content-between border rounded-3 px-3 py-3 bg-light-subtle">
                <div>
                    <label for="show_popup_on_english_only_single" class="form-label fw-semibold mb-1">Show Popup Ads on English Page Only</label>
                    <p class="text-muted mb-0 small">Enable this to display the popup ads on the Single English Page only.</p>
                </div>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" id="show_popup_on_english_only_single"
                        name="show_popup_on_english_only_single" value="1"
                        {{ isset($settings['show_popup_on_english_only_single']) && $settings['show_popup_on_english_only_single'] == 1 ? 'checked' : '' }}
                        style="width: 3rem; height: 1.5rem; cursor: pointer;" />
                </div>
            </div>


            {{-- Details --}}
            <div class="mb-3">
                <label class="form-label">Popup Ads</label>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="custom-table-sno">S.No</th>
                                <th style="width:40%">Image
                                    <span class="form-text text-muted">
                                        <small><i>(Recommended Size: 1080 x 608
                                                px)</i></small>
                                    </span>
                                </th>
                                <th style="width:40%">Link
                                </th>
                                <th style="width:10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="addMoreSliderGallerySingle">
                            @isset($settings['popup_ads_single'])
                                @php
                                    $chooseUs = unserialize($settings['popup_ads_single']);
                                @endphp
                                @foreach ($chooseUs as $index => $item)
                                    <tr>
                                        <td class="custom-table-no">{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="media-input image-input">
                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                    data-field="popup_ads_single{{ $index }}_image" data-select="single">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse</div>
                                                    </div>
                                                    <div class="form-control file-amount">
                                                        Choose
                                                        File</div>
                                                </div>
                                                <div class="preview-closer">
                                                    @if (isset($item['image']) && ($media = \App\Models\Media::where('id', $item['image'])->first()))
                                                        <input type="hidden" id="popup_ads_single{{ $index }}_image"
                                                            name="popup_ads_single[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div id="popup_ads_single{{ $index }}_image_select">
                                                            <div class="file-preview box sm">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                                    <div
                                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                        <img class="img-fit"
                                                                            src="{{ asset('storage/' . $media->file_name) }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="col body">
                                                                        <h6 class="d-flex">
                                                                            <span
                                                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                            <span
                                                                                class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                                        </h6>
                                                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="remove">
                                                                        <button data-id="{{ $item['image'] }}"
                                                                            data-slug="popup_ads_single{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button"><i
                                                                                class="bi bi-x-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" id="popup_ads_single{{ $index }}_image"
                                                            name="popup_ads_single[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div id="popup_ads_single{{ $index }}_image_select">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="url" name="popup_ads_single[{{ $index }}][link]"
                                                class="form-control" value="{{ $item['link'] ?? '' }}" />
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);"
                                                class="text-success fs-16 px-1 add_more_slider_gallery_single">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-danger fs-16 px-1 remove_slider_gallery_single">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <hr>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-single"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-single"
                                                title="Move Down">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-primary btn-sm add_slider_gallery_single">Add
                            Popup</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>



<!-- repeater script for Single Popup Ads -->
@push('backend-js')
<script>
    // Add new row - Single Gallery section
    $(document).on('click', '.add_slider_gallery_single', function() {
        let row = addSliderRowGallerySingle();
        $('.addMoreSliderGallerySingle').append(row);
        updateSerialNumbersSliderGallerySingle();
        updateOrderFieldsGallerySingle();
        updateRowIndicesGallerySingle();
        initializeMediaManagerForRowSingle($('.addMoreSliderGallerySingle tr:last'));
    });

    // Add more row after - Single Gallery section
    $(document).on('click', '.add_more_slider_gallery_single', function() {
        let clickedRow = $(this).closest('tr');
        let row = addSliderRowGallerySingle();
        clickedRow.after(row);
        updateSerialNumbersSliderGallerySingle();
        updateOrderFieldsGallerySingle();
        updateRowIndicesGallerySingle();
        initializeMediaManagerForRowSingle(clickedRow.next());
    });

    $(document).on('click', '.addMoreSliderGallerySingle .remove_slider_gallery_single', function() {
        $(this).closest('tr').remove();
        updateSerialNumbersSliderGallerySingle();
        updateOrderFieldsGallerySingle();
        updateRowIndicesGallerySingle();
    });

    // Move row up - Single Gallery section
    $(document).on('click', '.addMoreSliderGallerySingle .move-up-single', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersSliderGallerySingle();
            updateOrderFieldsGallerySingle();
            updateRowIndicesGallerySingle();
            setTimeout(function() {
                initializeSummernoteGallerySingle();
            }, 100);
        }
    });

    // Move row down - Single Gallery section
    $(document).on('click', '.addMoreSliderGallerySingle .move-down-single', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersSliderGallerySingle();
            updateOrderFieldsGallerySingle();
            updateRowIndicesGallerySingle();
            setTimeout(function() {
                initializeSummernoteGallerySingle();
            }, 100);
        }
    });

    function addSliderRowGallerySingle() {
        let numberOfRow = $('.addMoreSliderGallerySingle tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="popup_ads_single${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="popup_ads_single${numberOfRow}_image" name="popup_ads_single[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="popup_ads_single${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td>
                <input type="url" name="popup_ads_single[${numberOfRow}][link]" id="popup_ads_single_${numberOfRow}_link" class="form-control">
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_slider_gallery_single">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_slider_gallery_single">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-single" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-single" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateSerialNumbersSliderGallerySingle() {
        $('.addMoreSliderGallerySingle tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFieldsGallerySingle() {
        $('.addMoreSliderGallerySingle tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndicesGallerySingle() {
        $('.addMoreSliderGallerySingle tr').each(function(index) {
            let $row = $(this);

            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('popup_ads_single[')) {
                    let newName = currentName.replace(/popup_ads_single\[\d+\]/,
                        `popup_ads_single[${index}]`);
                    $element.attr('name', newName);
                }

                let currentId = $element.attr('id');
                if (currentId && currentId.includes('popup_ads_single')) {
                    if (currentId.includes('_image') && !currentId.includes('_image_select')) {
                        let newId = currentId.replace(/popup_ads_single\d+_image/,
                            `popup_ads_single${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_link')) {
                        let newId = currentId.replace(/popup_ads_single_\d+_link/,
                            `popup_ads_single_${index}_link`);
                        $element.attr('id', newId);
                    }
                }
            });

            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('popup_ads_single')) {
                    let newField = currentField.replace(/popup_ads_single\d+_image/,
                        `popup_ads_single${index}_image`);
                    $mediaManager.attr('data-field', newField);
                    $mediaManager.data('field', newField);
                }
            });

            $row.find('.preview-closer div[id*="popup_ads_single"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/popup_ads_single\d+_image_select/,
                        `popup_ads_single${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.preview-closer > div').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('popup_ads_single') && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/popup_ads_single\d+_image_select/,
                        `popup_ads_single${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('popup_ads_single')) {
                    let newSlug = currentSlug.replace(/popup_ads_single\d+_image/,
                        `popup_ads_single${index}_image`);
                    $button.attr('data-slug', newSlug);
                    $button.data('slug', newSlug);
                }
            });
        });
    }

    function initializeSummernoteOnElementGallerySingle($textarea) {
        if ($textarea.length && !$textarea.next('.note-editor').length && !$textarea.data('summernote')) {
            $textarea.summernote({
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['lineheight', ['lineheight']],
                    ['view', ['codeview', 'help']]
                ],
                fontSizes: ['8', '10', '12', '14', '16', '18', '24', '36'],
                lineHeights: ['1.0', '1.2', '1.4', '1.5', '1.6', '1.8', '2.0', '3.0'],
                callbacks: {
                    onImageUpload: function(files) {
                        const editor = $(this);
                        uploadImageGallerySingle(files[0], editor);
                    }
                }
            });
        }
    }

    function initializeSummernoteGallerySingle() {
        $('.addMoreSliderGallerySingle textarea.editor').each(function() {
            let $textarea = $(this);
            initializeSummernoteOnElementGallerySingle($textarea);
        });
    }

    function uploadImageGallerySingle(file, editor) {
        let formData = new FormData();
        formData.append("file", file);
        editor.summernote('saveRange');

        $.ajax({
            url: "{{ route('summernote.image.upload') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                editor.summernote('restoreRange');
                editor.summernote('focus');
                editor.summernote('insertImage', response.url, function($image) {
                    $image.css('width', '25%');
                });
            },
            error: function(xhr) {
                alert("Upload failed");
            }
        });
    }

    function initializeMediaManagerForRowSingle($row) {
        $row.find('.open-media-manager').off('click.single').on('click.single', function() {
            var fieldValue = $(this).attr('data-field') || $(this).data('field');
            var dataSelect = $(this).attr('data-select') || $(this).data('select');
            var mediaIds = $('#' + fieldValue).val() ? $('#' + fieldValue).val() : '';
            $('body').attr('data-field', fieldValue).attr('data-select', dataSelect).attr('data-ids', mediaIds);
            $('#exampleModal').attr('data-current-field', fieldValue).attr('data-current-select', dataSelect);
        });
    }

    $(document).ready(function() {
        initializeSummernoteGallerySingle();
        $('.addMoreSliderGallerySingle tr').each(function() {
            initializeMediaManagerForRowSingle($(this));
        });
    });
</script>
@endpush
