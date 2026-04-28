/**
 * Contains all Media Scripts.
 */
// import 'dropzone/dist/min/dropzone.min.js';

// Dropzone.autoDiscover = false;

var wtn;
// var token = WTNobj.token;
(function ($) {
    wtn = {
        init: function () {
            // this.dropzone_container();
            this.remove_thumbnail();
        },
        ie: function () {
            try {
                if (/MSIE (\d+\.\d+);/.test(navigator.userAgent) || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                    $('body').addClass('ie-user');
                    return true;
                }
            } catch (err) {
                console.log(err);
            }
            return false;
        },
        dropzone_container: () => {
            const dropzone = $("#image").dropzone({
                uploadprogress: function (file, progress, bytesSent) {
                    $("button[type=submit]").prop('disabled', true);
                },
                url: "/temp-images",
                maxFiles: 10,
                paramName: 'image',
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (file, response) {
                    var html = `<div class="col-md-3 mb-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                <a href="#" onclick="deleteImage(${response.image_id});" class="btn btn-danger">Delete</a>
                                <img src="${response.imagePath}" alt="" class="w-100 card-img-top">
                                <div class="card-body">
                                    <input type="text" name="caption[]"  value="" class="form-control"/>
                                    <input type="hidden" name="image_id[]" value="${response.image_id}"/>
                                </div>
                            </div>
                        </div>`;
                    $("#image-wrapper").append(html);
                    $("button[type=submit]").prop('disabled', false);
                    // this.removeFile(file);
                }
            });
        },
        remove_thumbnail: () => {
            $(document).on('click', '.remove-attachment', function () {
                var slug = $(this).data('slug');
                console.log('asd');
                var removeId = $(this).data('id');
                var currentIds = $('#' + slug).val();
                if (currentIds) {
                    var newValue = currentIds.split(',').filter(function (id) {
                        return id != removeId;
                    }).join(',');

                    $('#' + slug).val(newValue);
                }
                $(this).closest('.file-preview').remove();
            });
        },
    };
    $(function () {
        wtn.init();
    });
})(jQuery);
