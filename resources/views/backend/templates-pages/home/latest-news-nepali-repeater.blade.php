<!-- repeater -->
<script>
    // Build options HTML using the $all_posts_ne variable defined in home.blade.php
    @php
        $options_html = '<option value="">Choose News</option>';
        if (isset($all_posts_ne)) {
            foreach ($all_posts_ne as $post) {
                $options_html .= '<option value="' . $post->id . '">' . e($post->post_title) . '</option>';
            }
        }
    @endphp
    const postOptionsHtmlNepali = @json($options_html);

    // Add new row via main "Add News" button for Nepali
    $(document).on('click', '.add_latest_news_nepali', function() {
        let row = addLatestNewsNepaliRow();
        $('.addMoreLatestNewsNepali').append(row);
        updateLatestNewsNepaliSerialNumbers();
        updateLatestNewsNepaliRowIndices();
    });

    // Add row via inline "+" button inside a row for Nepali
    $(document).on('click', '.add_more_latest_news_nepali', function() {
        let clickedRow = $(this).closest('tr');
        let row = addLatestNewsNepaliRow();
        if (clickedRow.length) {
            clickedRow.after(row);
        } else {
            $('.addMoreLatestNewsNepali').append(row);
        }
        updateLatestNewsNepaliSerialNumbers();
        updateLatestNewsNepaliRowIndices();
    });

    // Remove row for Nepali
    $(document).on('click', '.remove_latest_news_nepali', function() {
        $(this).closest('tr').remove();
        updateLatestNewsNepaliSerialNumbers();
        updateLatestNewsNepaliRowIndices();
    });

    // Move row up for Nepali
    $(document).on('click', '.addMoreLatestNewsNepali .ln-move-up-nepali', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');
        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateLatestNewsNepaliSerialNumbers();
            updateLatestNewsNepaliRowIndices();
        }
    });

    // Move row down for Nepali
    $(document).on('click', '.addMoreLatestNewsNepali .ln-move-down-nepali', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');
        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateLatestNewsNepaliSerialNumbers();
            updateLatestNewsNepaliRowIndices();
        }
    });

    function addLatestNewsNepaliRow() {
        let numberOfRow = $('.addMoreLatestNewsNepali tr').length;
        let tr = `
        <tr>
            <td class="custom-table-no">${numberOfRow + 1}</td>
            <td>
                <select class="form-control"
                    name="latest_news_details_ne[${numberOfRow}][post_id]"
                    id="latest_news_details_ne_${numberOfRow}_post_id">
                    ${postOptionsHtmlNepali}
                </select>
            </td>
            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_latest_news_nepali">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_latest_news_nepali">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-up-nepali" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-down-nepali" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;
        return tr;
    }

    function updateLatestNewsNepaliSerialNumbers() {
        $('.addMoreLatestNewsNepali tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateLatestNewsNepaliRowIndices() {
        $('.addMoreLatestNewsNepali tr').each(function(index) {
            let $row = $(this);

            // Update select name and id attributes
            $row.find('select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');
                if (currentName && currentName.includes('latest_news_details_ne[')) {
                    let newName = currentName.replace(/latest_news_details_ne\[\d+\]/,
                        `latest_news_details_ne[${index}]`);
                    $element.attr('name', newName);
                }

                $element.attr('id', `latest_news_details_ne_${index}_post_id`);
            });
        });
    }
</script>
