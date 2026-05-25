<div class="tab-pane fade {{ request()->query('tab') == 'recent-news-ads' ? 'active show' : '' }}" id="recent-news-ads"
    role="tabpanel" aria-labelledby="recent-news-ads-tab">

    <div class="row">
        <div class="col-md-12">

            {{-- Details --}}
            <div class="mb-3">
                <label class="form-label">Recent News Ads</label>
                  <div>
                    <label for="show_popup" class="form-label fw-semibold mb-1">By adding this feature, you can display recent news ads on below each news of Recent News.</label>
                </div>
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
                        <tbody class="addMoreRecentNewsAds">
                            @isset($settings['recent_news_ads'])
                                @php
                                    $chooseUs = unserialize($settings['recent_news_ads']);
                                @endphp
                                @foreach ($chooseUs as $index => $item)
                                    <tr>
                                        <td class="custom-table-no">{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="media-input image-input">
                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                    data-field="recent_news_ads{{ $index }}_image" data-select="single">
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
                                                        <input type="hidden" id="recent_news_ads{{ $index }}_image"
                                                            name="recent_news_ads[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div id="recent_news_ads{{ $index }}_image_select">
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
                                                                            data-slug="recent_news_ads{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button"><i
                                                                                class="bi bi-x-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" id="recent_news_ads{{ $index }}_image"
                                                            name="recent_news_ads[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div id="recent_news_ads{{ $index }}_image_select">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="url" name="recent_news_ads[{{ $index }}][link]"
                                                class="form-control" value="{{ $item['link'] ?? '' }}" />
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);"
                                                class="text-success fs-16 px-1 add_more_recent_news_ads">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-danger fs-16 px-1 remove_recent_news_ads">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <hr>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-recent-news-ads"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-recent-news-ads"
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
                        <button type="button" class="btn btn-primary btn-sm add_recent_news_ads">Add
                            Popup</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>



<!-- repeater script for Recent News Ads -->
@push('backend-js')
<script>
    // Add new row - Recent News Ads section
    $(document).on('click', '.add_recent_news_ads', function() {
        let row = addRecentNewsAdsRow();
        $('.addMoreRecentNewsAds').append(row);
        updateSerialNumbersRecentNewsAds();
        updateOrderFieldsRecentNewsAds();
        updateRowIndicesRecentNewsAds();
        initializeMediaManagerForRecentNewsAdsRow($('.addMoreRecentNewsAds tr:last'));
    });

    // Add more row after - Recent News Ads section
    $(document).on('click', '.add_more_recent_news_ads', function() {
        let clickedRow = $(this).closest('tr');
        let row = addRecentNewsAdsRow();
        clickedRow.after(row);
        updateSerialNumbersRecentNewsAds();
        updateOrderFieldsRecentNewsAds();
        updateRowIndicesRecentNewsAds();
        initializeMediaManagerForRecentNewsAdsRow(clickedRow.next());
    });

    $(document).on('click', '.addMoreRecentNewsAds .remove_recent_news_ads', function() {
        $(this).closest('tr').remove();
        updateSerialNumbersRecentNewsAds();
        updateOrderFieldsRecentNewsAds();
        updateRowIndicesRecentNewsAds();
    });

    // Move row up - Recent News Ads section
    $(document).on('click', '.addMoreRecentNewsAds .move-up-recent-news-ads', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersRecentNewsAds();
            updateOrderFieldsRecentNewsAds();
            updateRowIndicesRecentNewsAds();
        }
    });

    // Move row down - Recent News Ads section
    $(document).on('click', '.addMoreRecentNewsAds .move-down-recent-news-ads', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersRecentNewsAds();
            updateOrderFieldsRecentNewsAds();
            updateRowIndicesRecentNewsAds();
        }
    });

    function addRecentNewsAdsRow() {
        let numberOfRow = $('.addMoreRecentNewsAds tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="recent_news_ads${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="recent_news_ads${numberOfRow}_image" name="recent_news_ads[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="recent_news_ads${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td>
                <input type="url" name="recent_news_ads[${numberOfRow}][link]" id="recent_news_ads_${numberOfRow}_link" class="form-control">
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_recent_news_ads">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_recent_news_ads">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up-recent-news-ads" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down-recent-news-ads" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateSerialNumbersRecentNewsAds() {
        $('.addMoreRecentNewsAds tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFieldsRecentNewsAds() {
        $('.addMoreRecentNewsAds tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndicesRecentNewsAds() {
        $('.addMoreRecentNewsAds tr').each(function(index) {
            let $row = $(this);

            // Update all name attributes to use the new index
            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('recent_news_ads[')) {
                    let newName = currentName.replace(/recent_news_ads\[\d+\]/,
                        `recent_news_ads[${index}]`);
                    $element.attr('name', newName);
                }

                // Update IDs for image and link fields
                let currentId = $element.attr('id');
                if (currentId && currentId.includes('recent_news_ads')) {
                    if (currentId.includes('_image') && !currentId.includes('_image_select')) {
                        let newId = currentId.replace(/recent_news_ads\d+_image/,
                            `recent_news_ads${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_link')) {
                        let newId = currentId.replace(/recent_news_ads_\d+_link/,
                            `recent_news_ads_${index}_link`);
                        $element.attr('id', newId);
                    }
                }
            });

            // Update data-field attributes for media manager
            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('recent_news_ads')) {
                    let newField = currentField.replace(/recent_news_ads\d+_image/,
                        `recent_news_ads${index}_image`);
                    $mediaManager.attr('data-field', newField);
                    $mediaManager.data('field', newField);
                }
            });

            // Update div IDs for image select
            $row.find('.preview-closer div[id*="recent_news_ads"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('_image_select')) {
                    let newId = currentId.replace(/recent_news_ads\d+_image_select/,
                        `recent_news_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            // Also update any divs that might be direct children of preview-closer
            $row.find('.preview-closer > div').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId && currentId.includes('recent_news_ads') && currentId.includes(
                        '_image_select')) {
                    let newId = currentId.replace(/recent_news_ads\d+_image_select/,
                        `recent_news_ads${index}_image_select`);
                    $div.attr('id', newId);
                }
            });

            // Update data-slug attributes on remove buttons
            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('recent_news_ads')) {
                    let newSlug = currentSlug.replace(/recent_news_ads\d+_image/,
                        `recent_news_ads${index}_image`);
                    $button.attr('data-slug', newSlug);
                    $button.data('slug', newSlug);
                }
            });
        });
    }

    // Initialize media manager bindings for a specific row
    function initializeMediaManagerForRecentNewsAdsRow($row) {
        $row.find('.open-media-manager').off('click').on('click', function() {
            var fieldValue = $(this).attr('data-field') || $(this).data('field');
            var dataSelect = $(this).attr('data-select') || $(this).data('select');
            var mediaIds = $('#' + fieldValue).val() ? $('#' + fieldValue).val() : '';
            $('body').attr('data-field', fieldValue).attr('data-select', dataSelect).attr('data-ids', mediaIds);
            $('#exampleModal').attr('data-current-field', fieldValue).attr('data-current-select', dataSelect);
        });
    }

    $(document).ready(function() {
        // Initialize media manager for all existing rows
        $('.addMoreRecentNewsAds tr').each(function() {
            initializeMediaManagerForRecentNewsAdsRow($(this));
        });
    });
</script>
@endpush
