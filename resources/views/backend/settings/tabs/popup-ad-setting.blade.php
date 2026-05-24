<div class="tab-pane fade {{ request()->query('tab') == 'popup-ad' ? 'active show' : '' }}" id="popup-ad" role="tabpanel"
    aria-labelledby="popup-ad-tab">

    <div class="row">
        <div class="col-md-12">

            <div
                class="mb-3 d-flex align-items-center justify-content-between border rounded-3 px-3 py-3 bg-light-subtle">
                <div>
                    <label for="show_popup" class="form-label fw-semibold mb-1">Show Popup Ads</label>
                    <p class="text-muted mb-0 small">Enable this to display the popup.</p>
                </div>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" id="show_popup" name="show_popup" value="1"
                        {{ isset($settings['show_popup']) && $settings['show_popup'] == 1 ? 'checked' : '' }}
                        style="width: 3rem; height: 1.5rem; cursor: pointer;" />
                </div>
            </div>

            <div
                class="mb-3 d-flex align-items-center justify-content-between border rounded-3 px-3 py-3 bg-light-subtle">
                <div>
                    <label for="show_popup_on_homepage" class="form-label fw-semibold mb-1">Show Popup Ads on Homepage
                        Only</label>
                    <p class="text-muted mb-0 small">Enable this to display the popup ads on the homepage only.</p>
                </div>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" id="show_popup_on_homepage"
                        name="show_popup_on_homepage" value="1"
                        {{ isset($settings['show_popup_on_homepage']) && $settings['show_popup_on_homepage'] == 1 ? 'checked' : '' }}
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
                        <tbody class="addMoreSliderGallery">
                            @isset($settings['popup_ads'])
                                @php
                                    $chooseUs = unserialize($settings['popup_ads']);
                                @endphp
                                @foreach ($chooseUs as $index => $item)
                                    <tr>
                                        <td class="custom-table-no">{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="media-input image-input">
                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                    data-field="popup_ads{{ $index }}_image" data-select="single">
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
                                                        <input type="hidden" id="popup_ads{{ $index }}_image"
                                                            name="popup_ads[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div id="popup_ads{{ $index }}_image_select">
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
                                                                            data-slug="popup_ads{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button"><i
                                                                                class="bi bi-x-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" id="popup_ads{{ $index }}_image"
                                                            name="popup_ads[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div id="popup_ads{{ $index }}_image_select">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="url" name="popup_ads[{{ $index }}][link]"
                                                class="form-control" value="{{ $item['link'] ?? '' }}" />
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);"
                                                class="text-success fs-16 px-1 add_more_slider_gallery">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-danger fs-16 px-1 remove_slider_gallery">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <hr>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down"
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
                        <button type="button" class="btn btn-primary btn-sm add_slider_gallery">Add
                            Detail</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<!-- repeater script for Popup Ads -->
<!-- repeater -->
<script>
    // Add new row - Gallery section
    $(document).on('click', '.add_slider_gallery', function() {
        let row = addSliderRowGallery();
        $('.addMoreSliderGallery').append(row);
        updateSerialNumbersSliderGallery();
        updateOrderFieldsGallery();
        updateRowIndicesGallery();
        initializeMediaManagerForRow($('.addMoreSliderGallery tr:last'));
    });

    // Add more row after - Gallery section
    $(document).on('click', '.add_more_slider_gallery', function() {
        let clickedRow = $(this).closest('tr');
        let row = addSliderRowGallery();
        clickedRow.after(row);
        updateSerialNumbersSliderGallery();
        updateOrderFieldsGallery();
        updateRowIndicesGallery();
        initializeMediaManagerForRow(clickedRow.next());
    });

    $(document).on('click', '.addMoreSliderGallery .remove_slider_gallery', function() {
        $(this).closest('tr').remove();
        updateSerialNumbersSliderGallery();
        updateOrderFieldsGallery();
        updateRowIndicesGallery();
    });

    // Move row up - Gallery section
    $(document).on('click', '.addMoreSliderGallery .move-up', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersSliderGallery();
            updateOrderFieldsGallery();
            updateRowIndicesGallery();
            // Re-initialize Summernote after moving
            setTimeout(function() {
                initializeSummernoteGallery();
            }, 100);
        }
    });

    // Move row down - Gallery section
    $(document).on('click', '.addMoreSliderGallery .move-down', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersSliderGallery();
            updateOrderFieldsGallery();
            updateRowIndicesGallery();
            // Re-initialize Summernote after moving
            setTimeout(function() {
                initializeSummernoteGallery();
            }, 100);
        }
    });

    function addSliderRowGallery() {
        let numberOfRow = $('.addMoreSliderGallery tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="popup_ads${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="popup_ads${numberOfRow}_image" name="popup_ads[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="popup_ads${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td>
                <input type="url" name="popup_ads[${numberOfRow}][link]" id="popup_ads_${numberOfRow}_link" class="form-control">
            </td>
    
            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_slider_gallery">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_slider_gallery">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateSerialNumbersSliderGallery() {
        $('.addMoreSliderGallery tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFieldsGallery() {
        $('.addMoreSliderGallery tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndicesGallery() {
        $('.addMoreSliderGallery tr').each(function(index) {
            let $row = $(this);

            // Update all name attributes to use the new index
            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('popup_ads[')) {
                    let newName = currentName.replace(/popup_ads\[\d+\]/,
                        `popup_ads[${index}]`);
                    $element.attr('name', newName);
                }

                // Update IDs for image and link fields - handle popup_ads0_image, popup_ads_0_link, etc.
                let currentId = $element.attr('id');
                if (currentId && currentId.includes('popup_ads')) {
                    if (currentId.includes('_image') && !currentId.includes('_image_select')) {
                        // Match pattern: popup_ads{number}_image
                        let newId = currentId.replace(/popup_ads\d+_image/,
                            `popup_ads${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_short_description')) {
                        // Match pattern: popup_ads_{number}_short_description
                        let newId = currentId.replace(/popup_ads_\d+_short_description/,
                            `popup_ads_${index}_short_description`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_link')) {
                        // Match pattern: popup_ads_{number}_link
                        let newId = currentId.replace(/popup_ads_\d+_link/,
                            `popup_ads_${index}_link`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_url')) {
                        // Match pattern: popup_ads_{number}_url
                        let newId = currentId.replace(/popup_ads_\d+_url/,
                            `popup_ads_${index}_url`);
                        $element.attr('id', newId);
                    }
                }
            });

            // Update data-field attributes for media manager
            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('popup_ads')) {
                    // Match pattern: popup_ads{number}_image
                    let newField = currentField.replace(/popup_ads\d+_image/,
                        `popup_ads${index}_image`);
                    $mediaManager.attr('data-field', newField);
                    $mediaManager.data('field', newField); // Also update jQuery data cache
                }
            });

            // Update div IDs for image select - this is critical for preview to work
            // Look in the preview-closer div specifically
            $row.find('.preview-closer div[id*="popup_ads"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('_image_select')) {
                    // Match pattern: popup_ads{number}_image_select
                    let newId = currentId.replace(/popup_ads\d+_image_select/,
                        `popup_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            // Also update any divs that might be direct children of preview-closer
            $row.find('.preview-closer > div').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('popup_ads') && currentId.includes(
                        '_image_select')) {
                    // Match pattern: popup_ads{number}_image_select
                    let newId = currentId.replace(/popup_ads\d+_image_select/,
                        `popup_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            // Update data-slug attributes on remove buttons
            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('popup_ads')) {
                    // Match pattern: popup_ads{number}_image
                    let newSlug = currentSlug.replace(/popup_ads\d+_image/,
                        `popup_ads${index}_image`);
                    $button.attr('data-slug', newSlug);
                    $button.data('slug', newSlug); // Also update jQuery data cache
                }
            });
        });
    }

    // Initialize Summernote editor on a specific textarea element
    function initializeSummernoteOnElementGallery($textarea) {
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
                        uploadImageGallery(files[0], editor);
                    }
                }
            });
        }
    }

    // Initialize Summernote editor on all textareas
    function initializeSummernoteGallery() {
        $('.addMoreSliderGallery textarea.editor').each(function() {
            let $textarea = $(this);
            initializeSummernoteOnElementGallery($textarea);
        });
    }

    // Upload image function for Summernote
    function uploadImageGallery(file, editor) {
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

    // Initialize media manager bindings for a specific row
    function initializeMediaManagerForRow($row) {
        // Ensure the media manager click handler works for this row
        $row.find('.open-media-manager').off('click').on('click', function() {
            var fieldValue = $(this).attr('data-field') || $(this).data('field');
            var dataSelect = $(this).attr('data-select') || $(this).data('select');
            var mediaIds = $('#' + fieldValue).val() ? $('#' + fieldValue).val() : '';
            $('body').attr('data-field', fieldValue).attr('data-select', dataSelect).attr('data-ids', mediaIds);
            $('#exampleModal').attr('data-current-field', fieldValue).attr('data-current-select', dataSelect);
        });
    }

    // Initialize Summernote on page load for existing textareas
    $(document).ready(function() {
        initializeSummernoteGallery();
        // Initialize media manager for all existing rows
        $('.addMoreSliderGallery tr').each(function() {
            initializeMediaManagerForRow($(this));
        });
    });
</script>
