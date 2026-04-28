<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                    <h4 class="header-title">SEO</h4>
                </div>
                <div class="seo-section">
                    <div class="mb-3">
                        <label for="seoTitle" class="form-label">Title</label>
                        <input name="seo_title" type="text" class="form-control" id="seoTitle"
                            value="{{ isset($metaDatas['seo_title']) ? $metaDatas['seo_title'] : '' }}"
                            aria-describedby="seoTitle" />
                        <p class="text-end mt-2">Char Count: <span id="titleCharCount">0</span></p>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="seoDescription">Meta
                            Description</label>
                        <textarea rows="8" name="seo_description" class="form-control"id="seoDescription">{{ isset($metaDatas['seo_description']) ? $metaDatas['seo_description'] : '' }}</textarea>
                    </div>
                    <p class="text-end">Char Count: <span id="descriptionCharCount">0</span></p>
                </div>
                <hr>
                <h5>Note<span class="text-danger">*</span></h5>
                <p class="text-muted fs-14">Use <code class="copyToClipboard" style="cursor: pointer;">%sitename%</code>
                    for the
                    site name, <code class="copyToClipboard" style="cursor: pointer;">%year%</code> for the current year
                    and <code class="copyToClipboard" style="cursor: pointer;">%nextyear%</code> for the next year.</p>
                {{-- <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                </div> --}}
                <div id="copied" class="d-none"><b>Copied!</b></div>
            </div>
        </div>
    </div>
</div>

@push('backend-js')
    <script>
        $('.copyToClipboard').click(function() {
            var clickContent = $(this).text();
            var $textArea = $('<textarea>').val(clickContent.trim());
            $('body').append($textArea);
            $textArea.select();
            document.execCommand('copy');
            $textArea.remove();

            $('#copied').removeClass('d-none').fadeIn();
            setTimeout(function() {
                $('#copied').addClass('d-none');
            }, 1000);
        });

        var seoTitle = document.getElementById('seoTitle');
        var titleCharCountSpan = document.getElementById('titleCharCount');

        var textarea = document.getElementById('seoDescription');
        var charCountSpan = document.getElementById('descriptionCharCount');
        // var wordCountSpan = document.getElementById('wordCount');

        // textarea.addEventListener('input', countWords);
        seoTitle.addEventListener('input', titleCountChars);
        textarea.addEventListener('input', countChars);

        // countWords();
        countChars();
        titleCountChars();

        // Function to count words
        function countWords() {
            // Get the value of the textarea
            var value = textarea.value;

            // If the value is empty, set word count to 0
            if (value.trim() === '') {
                wordCountSpan.textContent = '0';
                return;
            }

            // Split the value into an array of words
            var words = value.trim().split(/\s+/);

            wordCountSpan.textContent = words.length;
        }

        // Function to count characters
        function countChars() {
            // Get the value of the textarea
            var value = textarea.value;

            // Set the character count to the length of the value
            charCountSpan.textContent = value.length;
        }

        function titleCountChars() {
            // Get the value of the textarea
            var value = seoTitle.value;

            // Set the character count to the length of the value
            titleCharCountSpan.textContent = value.length;
        }
    </script>
@endpush
