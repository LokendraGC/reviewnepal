{{-- <div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') == 'header-advertisements' ? 'active show' : '' }}"
    id="header-advertisements" role="tabpanel" aria-labelledby="header-advertisements-tab"> --}}
      
    <div class="row">
        <div class="col-md-12">

            {{-- Details --}}
            <div class="mb-3">
                <label class="form-label">Below Masthead</label>
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
                        <tbody class="addMoreSliderGalleryBelowMastheadAds">
                            @isset($settings['below_masthead_ads'])
                                @php
                                    $chooseUs = unserialize($settings['below_masthead_ads']);
                                @endphp
                                @foreach ($chooseUs as $index => $item)
                                    <tr>
                                        <td class="custom-table-no">{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="media-input image-input">
                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                    data-field="below_masthead_ads{{ $index }}_image" data-select="single">
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
                                                        <input type="hidden" id="below_masthead_ads{{ $index }}_image"
                                                            name="below_masthead_ads[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div id="below_masthead_ads{{ $index }}_image_select">
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
                                                                            data-slug="below_masthead_ads{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button"><i
                                                                                class="bi bi-x-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" id="below_masthead_ads{{ $index }}_image"
                                                            name="below_masthead_ads[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div id="below_masthead_ads{{ $index }}_image_select">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="url" name="below_masthead_ads[{{ $index }}][link]"
                                                class="form-control" value="{{ $item['link'] ?? '' }}" />
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);"
                                                class="text-success fs-16 px-1 add_more_slider_gallery_below_masthead_ads">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-danger fs-16 px-1 remove_slider_gallery_below_masthead_ads">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <hr>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-below-masthead-ads"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-below-masthead-ads"
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
                        <button type="button" class="btn btn-primary btn-sm add_slider_gallery_below_masthead_ads">Add
                            Ad</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
{{-- </div> --}}


<!-- repeater script for Below Masthead Ads -->
@push('backend-js')
<script>
    // Add new row - Below Masthead Ads section
    $(document).on('click', '.add_slider_gallery_below_masthead_ads', function() {
        let row = addSliderRowGalleryBelowMastheadAds();
        $('.addMoreSliderGalleryBelowMastheadAds').append(row);
        updateSerialNumbersSliderGalleryBelowMastheadAds();
        updateOrderFieldsGalleryBelowMastheadAds();
        updateRowIndicesGalleryBelowMastheadAds();
        initializeMediaManagerForRowBelowMastheadAds($('.addMoreSliderGalleryBelowMastheadAds tr:last'));
    });

    // Add more row after - Below Masthead Ads section
    $(document).on('click', '.add_more_slider_gallery_below_masthead_ads', function() {
        let clickedRow = $(this).closest('tr');
        let row = addSliderRowGalleryBelowMastheadAds();
        clickedRow.after(row);
        updateSerialNumbersSliderGalleryBelowMastheadAds();
        updateOrderFieldsGalleryBelowMastheadAds();
        updateRowIndicesGalleryBelowMastheadAds();
        initializeMediaManagerForRowBelowMastheadAds(clickedRow.next());
    });

    $(document).on('click', '.addMoreSliderGalleryBelowMastheadAds .remove_slider_gallery_below_masthead_ads', function() {
        $(this).closest('tr').remove();
        updateSerialNumbersSliderGalleryBelowMastheadAds();
        updateOrderFieldsGalleryBelowMastheadAds();
        updateRowIndicesGalleryBelowMastheadAds();
    });

    // Move row up - Below Masthead Ads section
    $(document).on('click', '.addMoreSliderGalleryBelowMastheadAds .move-up-below-masthead-ads', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersSliderGalleryBelowMastheadAds();
            updateOrderFieldsGalleryBelowMastheadAds();
            updateRowIndicesGalleryBelowMastheadAds();
            setTimeout(function() {
                initializeSummernoteGalleryBelowMastheadAds();
            }, 100);
        }
    });

    // Move row down - Below Masthead Ads section
    $(document).on('click', '.addMoreSliderGalleryBelowMastheadAds .move-down-below-masthead-ads', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersSliderGalleryBelowMastheadAds();
            updateOrderFieldsGalleryBelowMastheadAds();
            updateRowIndicesGalleryBelowMastheadAds();
            setTimeout(function() {
                initializeSummernoteGalleryBelowMastheadAds();
            }, 100);
        }
    });

    function addSliderRowGalleryBelowMastheadAds() {
        let numberOfRow = $('.addMoreSliderGalleryBelowMastheadAds tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="below_masthead_ads${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="below_masthead_ads${numberOfRow}_image" name="below_masthead_ads[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="below_masthead_ads${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td>
                <input type="url" name="below_masthead_ads[${numberOfRow}][link]" id="below_masthead_ads_${numberOfRow}_link" class="form-control">
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_slider_gallery_below_masthead_ads">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_slider_gallery_below_masthead_ads">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-below-masthead-ads" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-below-masthead-ads" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateSerialNumbersSliderGalleryBelowMastheadAds() {
        $('.addMoreSliderGalleryBelowMastheadAds tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFieldsGalleryBelowMastheadAds() {
        $('.addMoreSliderGalleryBelowMastheadAds tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndicesGalleryBelowMastheadAds() {
        $('.addMoreSliderGalleryBelowMastheadAds tr').each(function(index) {
            let $row = $(this);

            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('below_masthead_ads[')) {
                    let newName = currentName.replace(/below_masthead_ads\[\d+\]/,
                        `below_masthead_ads[${index}]`);
                    $element.attr('name', newName);
                }

                let currentId = $element.attr('id');
                if (currentId && currentId.includes('below_masthead_ads')) {
                    if (currentId.includes('_image') && !currentId.includes('_image_select')) {
                        let newId = currentId.replace(/below_masthead_ads\d+_image/,
                            `below_masthead_ads${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_link')) {
                        let newId = currentId.replace(/below_masthead_ads_\d+_link/,
                            `below_masthead_ads_${index}_link`);
                        $element.attr('id', newId);
                    }
                }
            });

            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('below_masthead_ads')) {
                    let newField = currentField.replace(/below_masthead_ads\d+_image/,
                        `below_masthead_ads${index}_image`);
                    $mediaManager.attr('data-field', newField);
                    $mediaManager.data('field', newField);
                }
            });

            $row.find('.preview-closer div[id*="below_masthead_ads"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/below_masthead_ads\d+_image_select/,
                        `below_masthead_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.preview-closer > div').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('below_masthead_ads') && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/below_masthead_ads\d+_image_select/,
                        `below_masthead_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('below_masthead_ads')) {
                    let newSlug = currentSlug.replace(/below_masthead_ads\d+_image/,
                        `below_masthead_ads${index}_image`);
                    $button.attr('data-slug', newSlug);
                    $button.data('slug', newSlug);
                }
            });
        });
    }

    function initializeSummernoteOnElementGalleryBelowMastheadAds($textarea) {
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
                        uploadImageGalleryBelowMastheadAds(files[0], editor);
                    }
                }
            });
        }
    }

    function initializeSummernoteGalleryBelowMastheadAds() {
        $('.addMoreSliderGalleryBelowMastheadAds textarea.editor').each(function() {
            let $textarea = $(this);
            initializeSummernoteOnElementGalleryBelowMastheadAds($textarea);
        });
    }

    function uploadImageGalleryBelowMastheadAds(file, editor) {
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

    function initializeMediaManagerForRowBelowMastheadAds($row) {
        $row.find('.open-media-manager').off('click.belowMastheadAds').on('click.belowMastheadAds', function() {
            var fieldValue = $(this).attr('data-field') || $(this).data('field');
            var dataSelect = $(this).attr('data-select') || $(this).data('select');
            var mediaIds = $('#' + fieldValue).val() ? $('#' + fieldValue).val() : '';
            $('body').attr('data-field', fieldValue).attr('data-select', dataSelect).attr('data-ids', mediaIds);
            $('#exampleModal').attr('data-current-field', fieldValue).attr('data-current-select', dataSelect);
        });
    }

    $(document).ready(function() {
        initializeSummernoteGalleryBelowMastheadAds();
        $('.addMoreSliderGalleryBelowMastheadAds tr').each(function() {
            initializeMediaManagerForRowBelowMastheadAds($(this));
        });
    });
</script>
@endpush