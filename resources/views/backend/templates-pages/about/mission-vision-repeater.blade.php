<!-- repeater -->
<script>
    // Pages data for select2 dropdowns
    // const pagesData = @json($pages ?? []);

    // Add new row via main "Add Detail" button
    $(document).on('click', '.add_mission_vision', function() {
        let row = addMissionVisionRow();
        $('.addMoreMissionVision').append(row);
        updateMissionVisionSerialNumbers();
        updateMissionVisionOrderFields();
        updateMissionVisionRowIndices();
        initializeMissionVisionSummernote();
        initializeMissionVisionSelect2();
    });

    // Add row via inline "+" button inside a row
    $(document).on('click', '.add_more_mission_vision', function() {
        let clickedRow = $(this).closest('tr');
        let row = addMissionVisionRow();
        if (clickedRow.length) {
            clickedRow.after(row);
        } else {
            $('.addMoreMissionVision').append(row);
        }
        updateMissionVisionSerialNumbers();
        updateMissionVisionOrderFields();
        updateMissionVisionRowIndices();
        initializeMissionVisionSummernote();
        initializeMissionVisionSelect2();
    });

    $(document).on('click', '.remove_mission_vision', function() {
        $(this).closest('tr').remove();
        updateMissionVisionSerialNumbers();
        updateMissionVisionOrderFields();
        updateMissionVisionRowIndices();
    });

    // Move row up
    $(document).on('click', '.addMoreMissionVision .mv-move-up', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');
        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateMissionVisionSerialNumbers();
            updateMissionVisionOrderFields();
            updateMissionVisionRowIndices();
            initializeMissionVisionSummernote();
            initializeMissionVisionSelect2();
        }
    });

    // Move row down
    $(document).on('click', '.addMoreMissionVision .mv-move-down', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');
        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateMissionVisionSerialNumbers();
            updateMissionVisionOrderFields();
            updateMissionVisionRowIndices();
            initializeMissionVisionSummernote();
            initializeMissionVisionSelect2();
        }
    });

    function addMissionVisionRow() {
        let numberOfRow = $('.addMoreMissionVision tr').length;

        let tr = `
        <tr>
            <td class="custom-table-no no">${numberOfRow + 1}</td>
            <td>
                <input type="text" class="form-control" name="mission_and_vision_details[${numberOfRow}][title]" value="" />
            </td>
            <td>
                <textarea class="editor" id="content" name="mission_and_vision_details[${numberOfRow}][description]"></textarea>
            </td>
            <td>
                <div class="media-input image-input">
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="mission_and_vision_details_${numberOfRow}_image" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        <input type="hidden" id="mission_and_vision_details_${numberOfRow}_image" name="mission_and_vision_details[${numberOfRow}][image]" class="selected-files" value="" />
                        <div id="mission_and_vision_details_${numberOfRow}_image_select"></div>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_mission_vision">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_mission_vision">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 mv-move-up" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 mv-move-down" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;

        return tr;
    }

    function updateMissionVisionSerialNumbers() {
        $('.addMoreMissionVision tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateMissionVisionOrderFields() {
        $('.addMoreMissionVision tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateMissionVisionRowIndices() {
        $('.addMoreMissionVision tr').each(function(index) {
            let $row = $(this);

            // Update all name attributes
            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');
                if (currentName && currentName.includes('mission_and_vision_details[')) {
                    let newName = currentName.replace(/mission_and_vision_details\[\d+\]/,
                        `mission_and_vision_details[${index}]`);
                    $element.attr('name', newName);
                }

                // Update IDs for image and icon fields
                let currentId = $element.attr('id');
                if (currentId && currentId.includes('mission_and_vision_details')) {
                    if (currentId.includes('_image')) {
                        $element.attr('id', `mission_and_vision_details_${index}_image`);
                    } else if (currentId.includes('_icon')) {
                        $element.attr('id', `mission_and_vision_details_${index}_icon`);
                    }
                }
            });

            // Update data-field attributes for media manager
            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('mission_and_vision_details')) {
                    if (currentField.includes('_image')) {
                        $mediaManager.attr('data-field', `mission_and_vision_details_${index}_image`);
                    } else if (currentField.includes('_icon')) {
                        $mediaManager.attr('data-field', `mission_and_vision_details_${index}_icon`);
                    }
                }
            });

            // Update preview div IDs
            $row.find('div[id*="mission_and_vision_details"]').each(function() {
                let $div = $(this);
                let currentId = $div.attr('id');
                if (currentId) {
                    if (currentId.includes('_image_select')) {
                        $div.attr('id', `mission_and_vision_details_${index}_image_select`);
                    } else if (currentId.includes('_icon_select')) {
                        $div.attr('id', `mission_and_vision_details_${index}_icon_select`);
                    }
                }
            });

            // Update data-slug on remove buttons
            $row.find('.remove-attachment').each(function() {
                let $button = $(this);
                let currentSlug = $button.attr('data-slug');
                if (currentSlug && currentSlug.includes('mission_and_vision_details')) {
                    if (currentSlug.includes('_image')) {
                        $button.attr('data-slug', `mission_and_vision_details_${index}_image`);
                    } else if (currentSlug.includes('_icon')) {
                        $button.attr('data-slug', `mission_and_vision_details_${index}_icon`);
                    }
                }
            });
        });
    }

    function initializeMissionVisionSelect2() {
        $('.addMoreMissionVision select.select2[name*="[page]"]').each(function() {
            let $select = $(this);
            if (!$select.hasClass('select2-hidden-accessible')) {
                $select.select2();
                populateMissionVisionSelect2Pages($select);
            }
        });
    }

    function populateMissionVisionSelect2Pages($select) {
        if (pagesData && pagesData.length > 0) {
            let currentValue = $select.val() || '0';
            $select.find('option:not([value="0"])').remove();
            pagesData.forEach(function(page) {
                let option = new Option(page.post_title, page.id, false, false);
                $select.append(option);
            });
            $select.val(currentValue).trigger('change');
        }
    }

    // Initialize Summernote on dynamically added mission & vision textareas
    function initializeMissionVisionSummernote() {
        $('.addMoreMissionVision textarea.editor').each(function() {
            let $textarea = $(this);
            if (!$textarea.next('.note-editor').length && !$textarea.data('summernote')) {
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
                            if (typeof uploadImage === 'function') {
                                uploadImage(files[0], editor);
                            }
                        }
                    }
                });
            }
        });
    }
</script>