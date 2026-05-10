@props(['content' => '', 'post'])

@php
    $postMeta = $post->GetAllMetaData();
    $existingSummary = $postMeta['ai_summary'] ?? '';
@endphp

<div class="mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="ri-sparkling-line"></i> AI Summary
            </h5>
            <button type="button" id="btn-generate-summary" class="btn btn-sm btn-primary"
                onclick="generateAiSummary()">
                <i class="ri-sparkling-line me-1"></i>
                <span id="summary-btn-text">Generate Summary</span>
            </button>
        </div>
        <div class="card-body">
            <div id="summary-status" class="d-none alert alert-info py-2 mb-2">
                <i class="ri-loader-4-line ri-spin me-1"></i>
                <span id="summary-status-text">Generating summary with AI...</span>
            </div>
            <div id="summary-error" class="d-none alert alert-danger py-2 mb-2">
                <span id="summary-error-text"></span>
            </div>
            <textarea name="ai_summary" id="ai-summary-textarea" class="editor">{{ $existingSummary }}</textarea>
            <small class="text-muted mt-1 d-block">This summary will be saved with the post when you update.</small>
        </div>
    </div>
</div>

@push('backend-js')
    <script>
        function generateAiSummary() {
            // Get post content from the main editor (Summernote)
            const editorContent = document.querySelector('textarea[name="post_content"]');
            let content = '';

            // Try to get content from Summernote if initialized
            if (editorContent && typeof $ !== 'undefined') {
                try {
                    content = $(editorContent).summernote('code');
                } catch (e) {
                    content = editorContent.value;
                }
            } else if (editorContent) {
                content = editorContent.value;
            }

            // Strip HTML tags for plain text
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;
            const plainText = tempDiv.textContent || tempDiv.innerText || '';

            if (plainText.trim().length < 50) {
                const errorEl = document.getElementById('summary-error');
                const errorText = document.getElementById('summary-error-text');
                errorEl.classList.remove('d-none');
                errorText.textContent =
                    'Post content is too short to generate a summary. Please write at least 50 characters.';
                setTimeout(() => errorEl.classList.add('d-none'), 5000);
                return;
            }

            // Show loading state
            const btn = document.getElementById('btn-generate-summary');
            const btnText = document.getElementById('summary-btn-text');
            const statusEl = document.getElementById('summary-status');
            const errorEl = document.getElementById('summary-error');

            btn.disabled = true;
            btnText.textContent = 'Generating...';
            statusEl.classList.remove('d-none');
            errorEl.classList.add('d-none');

            fetch("{{ route('backend.ai.summarize') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                        '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    content: plainText
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Set content into the Summernote editor
                        const summaryEl = $('#ai-summary-textarea');
                        try {
                            summaryEl.summernote('code', data.summary);
                        } catch (e) {
                            summaryEl.val(data.summary);
                        }
                        statusEl.classList.add('d-none');
                    } else {
                        throw new Error(data.message || 'Unknown error');
                    }
                })
                .catch(error => {
                    errorEl.classList.remove('d-none');
                    document.getElementById('summary-error-text').textContent = 'Error: ' + error.message;
                    statusEl.classList.add('d-none');
                })
                .finally(() => {
                    btn.disabled = false;
                    btnText.textContent = 'Generate Summary';
                });
        }
    </script>
@endpush