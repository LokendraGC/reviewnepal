@vite(['resources/scss/app.scss', 'resources/scss/icons.scss'])
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="{{ asset('dropzone.min.css') }}">
<style>
    .toast {
        border-radius: 10px !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .row-action {
        color: #a7aaad;
        font-size: 12.5px;
        padding: 6px 0 0;
    }

    .fw-500 {
        font-weight: 500 !important;
    }

    .fw-600 {
        font-weight: 600 !important;
    }

    .fw-700 {
        font-weight: 700 !important;
    }

    .form-control {
        color: unset !important;
    }

    .custom-table-sno {
        width: 0px;
    }

    td.custom-table-no {
        background: #f4f4f4 !important;
    }


    .card {
        transition: border-color 0.3s ease;
        /* Smooth transition for border color change */
    }

    .card.selected {
        border-color: blue;
        /* Change border color when selected */
    }

    .card-img-top {
        height: 150px;
        width: auto;
        object-fit: contain;
    }

    .scroll-container::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar for Chrome, Safari, and Opera */
    }

    .scroll-container {
        -ms-overflow-style: none;
        /* Hide scrollbar for IE and Edge */
        scrollbar-width: none;
        /* Hide scrollbar for Firefox */
    }

    [data-selected="true"] .uploader-select {
        border: 1px solid #000000;
        background: rgba(0, 123, 255, 0.05);
    }

    .clearfix {
        content: '';
        display: table;
        clear: both;
    }

    .image-card {
        position: relative;
    }

    .image-card .btn-danger {
        position: absolute;
        right: 20px;
        top: 20px;
    }

    .file-preview.box.sm .file-preview-item {
        width: 100px;
    }

    .file-preview.box .file-preview-item {
        width: 160px;
        /* float: left; */
        margin-right: 0.5rem;
        padding: 0;
        display: block !important;
        position: relative;
    }

    .file-preview-item {
        padding: 8px;
        border: 1px solid #ebedf2;
        border-radius: 0.25rem;
    }

    .file-preview.box.sm .thumb {
        height: 65px;
    }

    .file-preview.box .thumb {
        width: 100%;
        max-width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 120px;
        border-radius: 0;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .file-preview-item .thumb {
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        max-width: 50px;
        height: 45px;
        width: 50px;
        text-align: center;
        background: #f1f2f4;
        font-size: 20px;
        color: #92969b;
        border-radius: 0.25rem;
        overflow: hidden;
    }

    .file-preview-item h6 {
        font-size: 13px;
        margin-bottom: 0;
    }

    .file-preview-item p {
        font-size: 10px;
        margin-bottom: 0;
        color: var(--secondary);
    }

    .file-preview.box .remove {
        position: absolute;
        top: -6px;
        right: -6px;
        width: auto;
        max-width: 100%;
    }

    .file-preview.box .remove .btn {
        padding: 0;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #eaeaea;
    }

    .img-fit {
        max-height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .file-preview.box .body {
        padding: 0;
        padding: 8px 8px 2px;
    }

    .file-preview-item .body {
        min-width: 0;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #ddd !important;
        color: #3c434a !important;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #000000 !important;
    }
</style>
