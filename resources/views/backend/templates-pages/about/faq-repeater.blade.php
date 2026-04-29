<script>
    // Download section - slider
    $(document).on('click', '.add_slider', function() {
        let row = addSliderRow();
        $('.addMoreSlider').append(row);
        updateSerialNumbersSlider();
        updateOrderFields();
        initializeSummernote();
    });

    $(document).on('click', '.add_more_slider', function() {
        let clickedRow = $(this).closest('tr');
        let row = addSliderRow();
        clickedRow.after(row);
        updateSerialNumbersSlider();
        updateOrderFields();
        initializeSummernote();
    });

    $('.addMoreSlider').delegate('.remove_slider', 'click', function() {
        $(this).parent().parent().remove();
        updateSerialNumbersSlider();
        updateOrderFields();
    });

    // Move row up - Download section
    $(document).on('click', '.addMoreSlider .move-up', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateSerialNumbersSlider();
            updateOrderFields();
            updateRowIndices();
            initializeSummernote();
        }
    });

    // Move row down - Download section
    $(document).on('click', '.addMoreSlider .move-down', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');

        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateSerialNumbersSlider();
            updateOrderFields();
            updateRowIndices();
            initializeSummernote();
        }
    });

    function addSliderRow() {
        let numberOfRow = $('.addMoreSlider tr').length;
        let tr = `
    <tr>
        <td class="custom-table-no no">${numberOfRow + 1}</td>
       
        <td>
            <input type="text" name="faq_details[${numberOfRow}][question]" class="form-control" value="" />
        </td>
        <td>
                <textarea class="editor" name="faq_details[${numberOfRow}][answer]"
                    rows="5"></textarea>
        </td>
       
        <td class="text-center">
            <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_slider">
                <i class="bi bi-plus-circle"></i>
            </a>
            <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_slider">
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

    function updateSerialNumbersSlider() {
        $('.addMoreSlider tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateOrderFields() {
        $('.addMoreSlider tr').each(function(index) {
            $(this).find('.row-order').val(index);
        });
    }

    function updateRowIndices() {
        $('.addMoreSlider tr').each(function(index) {
            let $row = $(this);

            // Update all name attributes to use the new index
            $row.find('input, textarea, select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');

                if (currentName && currentName.includes('faq_details[')) {
                    let newName = currentName.replace(/faq_details\[\d+\]/, `faq_details[${index}]`);
                    $element.attr('name', newName);
                }

                // Update IDs for image and PDF fields
                let currentId = $element.attr('id');
                if (currentId && currentId.includes('faq_details')) {
                    if (currentId.includes('_image')) {
                        let newId = currentId.replace(/faq_details_\d+_image/, `faq_details_${index}_image`);
                        $element.attr('id', newId);
                    } else if (currentId.includes('_pdf')) {
                        let newId = currentId.replace(/faq_details_\d+_pdf/, `faq_details_${index}_pdf`);
                        $element.attr('id', newId);
                    }
                }
            });

            // Update data-field attributes for media manager
            $row.find('.open-media-manager').each(function() {
                let $mediaManager = $(this);
                let currentField = $mediaManager.attr('data-field');
                if (currentField && currentField.includes('faq_details')) {
                    if (currentField.includes('_image')) {
                        let newField = currentField.replace(/faq_details_\d+_image/, `faq_details_${index}_image`);
                        $mediaManager.attr('data-field', newField);
                    } else if (currentField.includes('_pdf')) {
                        let newField = currentField.replace(/faq_details_\d+_pdf/, `faq_details_${index}_pdf`);
                        $mediaManager.attr('data-field', newField);
                    }
                }
            });


        });
    }

    // Initialize Summernote editor on new textareas
    function initializeSummernote() {
        $('.addMoreSlider textarea.editor').each(function() {
            let $textarea = $(this);
            // Check if Summernote is already initialized on this textarea
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
        initializeSummernote();
    });
</script>