<div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') == 'header-advertisements' ? 'active show' : '' }}"
    id="header-advertisements" role="tabpanel" aria-labelledby="header-advertisements-tab">
      <div class="row">
        <div class="col-md-12">

            {{-- Details --}}
            <div class="mb-3">
                <label class="form-label">Masthead ads</label>
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
                        <tbody class="addMoreSliderGalleryHeaderAds">
                            @isset($settings['header_popup_ads'])
                                @php
                                    $chooseUs = unserialize($settings['header_popup_ads']);
                                @endphp
                                @foreach ($chooseUs as $index => $item)
                                    <tr>
                                        <td class="custom-table-no">{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="media-input image-input">
                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                    data-field="header_popup_ads{{ $index }}_image" data-select="single">
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
                                                        <input type="hidden" id="header_popup_ads{{ $index }}_image"
                                                            name="header_popup_ads[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div id="header_popup_ads{{ $index }}_image_select">
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
                                                                            data-slug="header_popup_ads{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button"><i
                                                                                class="bi bi-x-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" id="header_popup_ads{{ $index }}_image"
                                                            name="header_popup_ads[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div id="header_popup_ads{{ $index }}_image_select">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="url" name="header_popup_ads[{{ $index }}][link]"
                                                class="form-control" value="{{ $item['link'] ?? '' }}" />
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);"
                                                class="text-success fs-16 px-1 add_more_slider_gallery_header_ads">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-danger fs-16 px-1 remove_slider_gallery_header_ads">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <hr>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-header-ads"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-header-ads"
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
                        <button type="button" class="btn btn-primary btn-sm add_slider_gallery_header_ads">Add
                            Popup</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- repeater script for Header Ads Popup -->
@push('backend-js')
<script>
    // Add new row - Header Ads section
    $(document).on('click', '.add_slider_gallery_header_ads', function() {
        let row = addSliderRowGalleryHeaderAds();
        $('.addMoreSliderGalleryHeaderAds').append(row);
        updateSerialNumbersSliderGalleryHeaderAds();
        updateOrderFieldsGalleryHeaderAds();
        updateRowIndicesGalleryHeaderAds();
        initializeMediaManagerForRowHeaderAds($('.addMoreSliderGalleryHeaderAds tr:last'));
    });

    // Add more row after - Header Ads section
    $(document).on('click', '.add_more_slider_gallery_header_ads', function() {
        let clickedRow = $(this).closest('tr');
        let row = addSliderRowGalleryHeaderAds();
        clickedRow.after(row);
        updateSerialNumbersSliderGalleryHeaderAds();
        updateOrderFieldsGalleryHeaderAds();
        updateRowIndicesGalleryHeaderAds();
        initializeMediaManagerForRowHeaderAds(clickedRow.next());
    });

    $(document).on('click', '.addMoreSliderGalleryHeaderAds .remove_slider_gallery_header_ads', function() {
        $(this).closest('tr').remove();
        updateSerialNumbersSliderGalleryHeaderAds();
        updateOrderFieldsGalleryHeaderAds();
        updateRowIndicesGalleryHeaderAds();
    });

    // Move row up - Header Ads section
    $(document).on('click', '.addMoreSliderGalleryHeaderAds .move-up-header-ads', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersSliderGalleryHeaderAds();
            updateOrderFieldsGalleryHeaderAds();
            updateRowIndicesGalleryHeaderAds();
            setTimeout(function() {
                initializeSummernoteGalleryHeaderAds();
            }, 100);
        }
    });

    // Move row down - Header Ads section
    $(document).on('click', '.addMoreSliderGalleryHeaderAds .move-down-header-ads', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersSliderGalleryHeaderAds();
            updateOrderFieldsGalleryHeaderAds();
            updateRowIndicesGalleryHeaderAds();
            setTimeout(function() {
                initializeSummernoteGalleryHeaderAds();
            }, 100);
        }
    });

    function addSliderRowGalleryHeaderAds() {
        let numberOfRow = $('.addMoreSliderGalleryHeaderAds tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="header_popup_ads${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="header_popup_ads${numberOfRow}_image" name="header_popup_ads[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="header_popup_ads${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td>
                <input type="url" name="header_popup_ads[${numberOfRow}][link]" id="header_popup_ads_${numberOfRow}_link" class="form-control">
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_slider_gallery_header_ads">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_slider_gallery_header_ads">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-header-ads" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-header-ads" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateSerialNumbersSliderGalleryHeaderAds() {
        $('.addMoreSliderGalleryHeaderAds tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFieldsGalleryHeaderAds() {
        $('.addMoreSliderGalleryHeaderAds tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndicesGalleryHeaderAds() {
        $('.addMoreSliderGalleryHeaderAds tr').each(function(index) {
            let $row = $(this);

            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('header_popup_ads[')) {
                    let newName = currentName.replace(/header_popup_ads\[\d+\]/,
                        `header_popup_ads[${index}]`);
                    $element.attr('name', newName);
                }

                let currentId = $element.attr('id');
                if (currentId && currentId.includes('header_popup_ads')) {
                    if (currentId.includes('_image') && !currentId.includes('_image_select')) {
                        let newId = currentId.replace(/header_popup_ads\d+_image/,
                            `header_popup_ads${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_link')) {
                        let newId = currentId.replace(/header_popup_ads_\d+_link/,
                            `header_popup_ads_${index}_link`);
                        $element.attr('id', newId);
                    }
                }
            });

            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('header_popup_ads')) {
                    let newField = currentField.replace(/header_popup_ads\d+_image/,
                        `header_popup_ads${index}_image`);
                    $mediaManager.attr('data-field', newField);
                    $mediaManager.data('field', newField);
                }
            });

            $row.find('.preview-closer div[id*="header_popup_ads"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/header_popup_ads\d+_image_select/,
                        `header_popup_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.preview-closer > div').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('header_popup_ads') && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/header_popup_ads\d+_image_select/,
                        `header_popup_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('header_popup_ads')) {
                    let newSlug = currentSlug.replace(/header_popup_ads\d+_image/,
                        `header_popup_ads${index}_image`);
                    $button.attr('data-slug', newSlug);
                    $button.data('slug', newSlug);
                }
            });
        });
    }

    function initializeSummernoteOnElementGalleryHeaderAds($textarea) {
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
                        uploadImageGalleryHeaderAds(files[0], editor);
                    }
                }
            });
        }
    }

    function initializeSummernoteGalleryHeaderAds() {
        $('.addMoreSliderGalleryHeaderAds textarea.editor').each(function() {
            let $textarea = $(this);
            initializeSummernoteOnElementGalleryHeaderAds($textarea);
        });
    }

    function uploadImageGalleryHeaderAds(file, editor) {
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

    function initializeMediaManagerForRowHeaderAds($row) {
        $row.find('.open-media-manager').off('click.headerAds').on('click.headerAds', function() {
            var fieldValue = $(this).attr('data-field') || $(this).data('field');
            var dataSelect = $(this).attr('data-select') || $(this).data('select');
            var mediaIds = $('#' + fieldValue).val() ? $('#' + fieldValue).val() : '';
            $('body').attr('data-field', fieldValue).attr('data-select', dataSelect).attr('data-ids', mediaIds);
            $('#exampleModal').attr('data-current-field', fieldValue).attr('data-current-select', dataSelect);
        });
    }

    $(document).ready(function() {
        initializeSummernoteGalleryHeaderAds();
        $('.addMoreSliderGalleryHeaderAds tr').each(function() {
            initializeMediaManagerForRowHeaderAds($(this));
        });
    });
</script>
@endpush