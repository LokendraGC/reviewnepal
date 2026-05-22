<!-- repeater -->
<script>
    // Build options HTML by querying posts directly so this template is self-contained
    @php
        $posts = \App\Helpers\PostHelper::getModel()
            ->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->latest()
            ->limit(20)
            ->get();

        $options_html = '<option value="">Choose News</option>';
        foreach ($posts as $post) {
            $options_html .= '<option value="' . $post->id . '">' . e($post->post_title) . '</option>';
        }
    @endphp
    const postOptionsHtml = @json($options_html);

    // Add new row via main "Add News" button
    $(document).on('click', '.add_latest_news', function() {
        let row = addLatestNewsRow();
        $('.addMoreLatestNews').append(row);
        updateLatestNewsSerialNumbers();
        updateLatestNewsRowIndices();
    });

    // Add row via inline "+" button inside a row
    $(document).on('click', '.add_more_latest_news', function() {
        let clickedRow = $(this).closest('tr');
        let row = addLatestNewsRow();
        if (clickedRow.length) {
            clickedRow.after(row);
        } else {
            $('.addMoreLatestNews').append(row);
        }
        updateLatestNewsSerialNumbers();
        updateLatestNewsRowIndices();
    });

    // Remove row
    $(document).on('click', '.remove_latest_news', function() {
        $(this).closest('tr').remove();
        updateLatestNewsSerialNumbers();
        updateLatestNewsRowIndices();
    });

    // Move row up
    $(document).on('click', '.addMoreLatestNews .ln-move-up', function() {
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');
        if (prevRow.length) {
            currentRow.insertBefore(prevRow);
            updateLatestNewsSerialNumbers();
            updateLatestNewsRowIndices();
        }
    });

    // Move row down
    $(document).on('click', '.addMoreLatestNews .ln-move-down', function() {
        let currentRow = $(this).closest('tr');
        let nextRow = currentRow.next('tr');
        if (nextRow.length) {
            currentRow.insertAfter(nextRow);
            updateLatestNewsSerialNumbers();
            updateLatestNewsRowIndices();
        }
    });

    function addLatestNewsRow() {
        let numberOfRow = $('.addMoreLatestNews tr').length;
        let tr = `
        <tr>
            <td class="custom-table-no">${numberOfRow + 1}</td>
            <td>
                <select class="form-control"
                    name="latest_news_details[${numberOfRow}][post_id]"
                    id="latest_news_details_${numberOfRow}_post_id">
                    ${postOptionsHtml}
                </select>
            </td>
            <td class="text-center">
                <a href="javascript:void(0);" class="text-success fs-16 px-1 add_more_latest_news">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger fs-16 px-1 remove_latest_news">
                    <i class="bi bi-x-circle"></i>
                </a>
                <hr>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-up" title="Move Up">
                    <i class="bi bi-arrow-up-circle"></i>
                </a>
                <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-down" title="Move Down">
                    <i class="bi bi-arrow-down-circle"></i>
                </a>
            </td>
        </tr>
    `;
        return tr;
    }

    function updateLatestNewsSerialNumbers() {
        $('.addMoreLatestNews tr').each(function(index) {
            $(this).find('.custom-table-no').text(index + 1);
        });
    }

    function updateLatestNewsRowIndices() {
        $('.addMoreLatestNews tr').each(function(index) {
            let $row = $(this);

            // Update select name and id attributes
            $row.find('select').each(function() {
                let $element = $(this);
                let currentName = $element.attr('name');
                if (currentName && currentName.includes('latest_news_details[')) {
                    let newName = currentName.replace(/latest_news_details\[\d+\]/,
                        `latest_news_details[${index}]`);
                    $element.attr('name', newName);
                }

                $element.attr('id', `latest_news_details_${index}_post_id`);
            });
        });
    }
</script>
