<script>
    // Team section - repeater
    $(document).on('click', '.add_team', function() {
        let row = addTeamRow();
        $('.addMoreTeam').append(row);
        updateTeamSerialNumbers();
        updateOrderFields();
        initializeTeamSummernote();
    });

    $(document).on('click', '.add_more_team', function() {
        let clickedRow = $(this).closest('tr');
        let row = addTeamRow();
        clickedRow.after(row);
        updateTeamSerialNumbers();
        updateOrderFields();
        initializeTeamSummernote();
    });

    $('.addMoreTeam').delegate('.remove_team', 'click', function() {
        $(this).closest('tr').remove();
        updateTeamSerialNumbers();
        updateOrderFields();
    });

    // Move row up
    $(document).on('click', '.addMoreTeam .move-up', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateTeamSerialNumbers();
            updateOrderFields();
            updateRowIndices();
            initializeTeamSummernote();
        }
    });

    // Move row down
    $(document).on('click', '.addMoreTeam .move-down', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateTeamSerialNumbers();
            updateOrderFields();
            updateRowIndices();
            initializeTeamSummernote();
        }
    });

    function addTeamRow() {
        let numberOfRow = $('.addMoreTeam tr').length;
        let tr = `
    <tr>
        <td class="custom-table-sno">${numberOfRow + 1}</td>
       
        <td>
            <input type="text" name="team_details[${numberOfRow}][name]" class="form-control" value="" />
        </td>
        <td>
            <input type="text" name="team_details[${numberOfRow}][designation]" class="form-control" value="" />
        </td>
        <td>
            <div class="media-input image-input">
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;" data-field="team_details_${numberOfRow}_image" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                <div class="preview-closer">
                    <input type="hidden" id="team_details_${numberOfRow}_image" name="team_details[${numberOfRow}][image]" class="selected-files" value="" />
                    <div id="team_details_${numberOfRow}_image_select"></div>
                </div>
            </div>
        </td>
        <td class="text-center">
            <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_team">
                <i class="bi bi-plus-circle"></i>
            </a>
            <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_team">
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

    function updateTeamSerialNumbers() {
        $('.addMoreTeam tr').each(function(index) {
            $(this).find('.custom-table-sno').text(index + 1);
        });
    }

    function updateOrderFields() {
        $('.addMoreTeam tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndices() {
        $('.addMoreTeam tr').each(function(index) {
            let $row = $(this);

            // Update all name attributes to use the new index
            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('team_details[')) {
                    let newName = currentName.replace(/team_details\[\d+\]/, `team_details[${index}]`);
                    $element.attr('name', newName);
                }

                // Update IDs for image, PDF, and editor fields
                let currentId = $element.attr('id');
                if (currentId) {
                    if (currentId.includes('team_details_') && currentId.includes('_image')) {
                        $element.attr('id', `team_details_${index}_image`);
                    } else if (currentId.includes('team_details_') && currentId.includes('_pdf')) {
                        $element.attr('id', `team_details_${index}_pdf`);
                    } else if (currentId.includes('team_editor_')) {
                        $element.attr('id', `team_editor_${index}`);
                    }
                }
            });

            // Update data-field attributes for media manager
            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('team_details')) {
                    if (currentField.includes('_image')) {
                        let newField = currentField.replace(/team_details_\d+_image/, `team_details_${index}_image`);
                        $mediaManager.attr('data-field', newField);
                    } else if (currentField.includes('_pdf')) {
                        let newField = currentField.replace(/team_details_\d+_pdf/, `team_details_${index}_pdf`);
                        $mediaManager.attr('data-field', newField);
                    }
                }
            });

            // Update preview div IDs for media manager
            $row.find('[id^="team_details_"][id$="_image_select"]').each(function() {
                let $previewDiv = $(this);
                let newId = `team_details_${index}_image_select`;
                $previewDiv.attr('id', newId);
            });
        });
    }

    // Initialize Summernote editor on team repeater textareas
    function initializeTeamSummernote() {
        $('.addMoreTeam textarea.team-editor').each(function() {
            let $textarea = $(this);
            if (!$textarea.next('.note-editor').length && !$textarea.data('summernote')) {
                $textarea.summernote({
                    tabsize: 2,
                    height: 200,
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

    $(document).ready(function() {
        initializeTeamSummernote();
    });
</script>