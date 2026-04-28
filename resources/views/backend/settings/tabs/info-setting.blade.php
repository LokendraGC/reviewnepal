<div class="tab-pane fade {{ request()->query('tab') == 'info-section' ? 'active show' : '' }}" id="info-section"
    role="tabpanel" aria-labelledby="info-section-tab">
    <div class="row">
        <div class="col">
            <label for="emailAddress" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="emailAddress" name="email_address"
                value="{{ isset($settings['email_address']) ? $settings['email_address'] : '' }}" />
        </div>
    </div>
    <hr />
    
     <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="first_email" class="form-label">First Email</label>
                <input type="email" class="form-control" id="first_email" name="first_email"
                    value="{{ isset($settings['first_email']) ? $settings['first_email'] : '' }}" />
            </div>
            <div class="mb-3">
                <label for="first_phone" class="form-label">First Phone</label>
                <input type="text" class="form-control" id="first_phone" name="first_phone"
                    value="{{ isset($settings['first_phone']) ? $settings['first_phone'] : '' }}" />
            </div>
        </div>
        <div class="col-md-6">

            <div class="mb-3">
                <label for="second_email" class="form-label">Second Email</label>
                <input type="email" class="form-control" id="second_email" name="second_email"
                    value="{{ isset($settings['second_email']) ? $settings['second_email'] : '' }}" />
            </div>
            <div class="mb-3">
                <label for="second_phone" class="form-label">Second Phone</label>
                <input type="text" class="form-control" id="second_phone" name="second_phone"
                    value="{{ isset($settings['second_phone']) ? $settings['second_phone'] : '' }}" />
            </div>
        </div>
    </div>
    <hr />

      <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="map_link" class="form-label">Map Link</label>
                <input type="text" class="form-control" id="map_link" name="map_link"
                    value="{{ isset($settings['map_link']) ? $settings['map_link'] : '' }}" />
            </div>
        </div>

     <div class="mb-3">
        <label for="map_iframe_url" class="form-label">Map Iframe URL</label>
        <textarea class="form-control" name="map_iframe_url" id="map_iframe_url" cols="30" rows="10">{{ isset($settings['map_iframe_url']) ? $settings['map_iframe_url'] : '' }}</textarea>
    </div>
    </div>
    <hr />

 <div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="social-media" class="form-label">Social Media</label>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="custom-table-sno" style="width: 40px;"><i class="bi bi-grip-vertical"></i></th>
                            <th class="custom-table-sno">S.No</th>
                            <th>Media</th>
                            <th>Link</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="addMoreItem_s">
                        @isset($settings['social_media'])
                            @php
                                $socialMedia = unserialize($settings['social_media']);
                            @endphp
                            @foreach ($socialMedia as $index => $data)
                                <tr style="cursor: move;">
                                    <td class="drag-handle" style="cursor: move;">
                                        <i class="bi bi-grip-vertical text-muted"></i>
                                    </td>
                                    <td class="custom-table-no no">{{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <select name="social_media[{{ $index }}][media]" class="form-control select2"
                                            data-toggle="select2">
                                            @foreach (\App\Enums\SocialMediaType::getKeyValuePairs() as $label => $value)
                                                <option value="{{ $value }}"
                                                    @if (isset($data['media']) && $value == $data['media']) selected @endif>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="url" class="form-control"
                                            name="social_media[{{ $index }}][link]"
                                            value="{{ isset($data['link']) ? $data['link'] : '' }}" />
                                    </td>
                                    <td class="text-center"><a href="javascript: void(0);"
                                            class="text-reset fs-16 px-1 add_more">
                                            <i class="bi bi-plus-circle"></i></a> <a href="javascript: void(0);"
                                            class="text-reset fs-16 px-1 remove"> <i class="bi bi-x-circle"></i></a></td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-primary btn-sm add_new_row">Add
                        New</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@push('backend-js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        // tab url
        document.addEventListener('DOMContentLoaded', function() {

            const tabs = document.querySelectorAll('a.nav-link');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = tab.getAttribute('href').substr(1);
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('tab', tabId);
                    const newUrl = window.location.pathname + '?' + urlParams.toString();
                    history.pushState({}, '', newUrl);
                });
            });
        });
    </script>
    <script>
        // select2 reinitialize
        function selectReinitialize() {
            $('.select2').select2();
        }

        // updateSerialNumbers
        function updateSerialNumbers() {
            $('.addMoreItem_s tr').each(function(index) {
                let newIndex = index;
                // Update serial number (second td, after drag handle)
                $(this).find('td').eq(1).text(index + 1);
                // Update form field names
                $(this).find('select').attr('name', 'social_media[' + newIndex + '][media]');
                $(this).find('input').attr('name', 'social_media[' + newIndex + '][link]');
            });
        }

        // add new row
        function addRowData() {
            let numberOfRow = $('.addMoreItem_s tr').length;
            let options = '';

            options = '<option value="none" selected disabled>Select</option>';
            @foreach (\App\Enums\SocialMediaType::getKeyValuePairs() as $key => $value)
                options += `<option value="{{ $value }}">{{ $key }}</option>`;
            @endforeach

            let tr = `
            <tr style="cursor: move;">
                <td class="drag-handle" style="cursor: move;">
                    <i class="bi bi-grip-vertical text-muted"></i>
                </td>
                <td class="custom-table-no no">${numberOfRow + 1}</td>
                <td>
                    <select class="form-control select2" data-toggle="select2" name="social_media[${numberOfRow}][media]">
                        ${options}
                    </select>
                </td>
                <td><input name="social_media[${numberOfRow}][link]" class="form-control" /></td>
                <td class="text-center">
                    <a href="javascript: void(0);" class="text-reset fs-16 px-1 add_more"><i class="bi bi-plus-circle"></i></a>
                    <a href="javascript: void(0);" class="text-reset fs-16 px-1 remove"><i class="bi bi-x-circle"></i></a>
                </td>
            </tr>
        `;

            return tr;
        }



        // click on icon
        $(document).on('click', '.add_more', function() {
            let clickedRow = $(this).closest('tr');
            let row = addRowData();
            clickedRow.after(row);
            updateSerialNumbers();
            selectReinitialize();
        });

        // click on add new button
        $(document).off('click', '.add_new_row').on('click', '.add_new_row', function() {
            let row = addRowData();
            $('.addMoreItem_s').append(row);
            updateSerialNumbers();
            selectReinitialize();
        });


        // click on remove
        $('.addMoreItem_s').delegate('.remove', 'click', function() {
            $(this).closest('tr').remove();
            updateSerialNumbers();
        });

        // Initialize SortableJS for drag and drop
        $(document).ready(function() {
            const tbody = document.querySelector('.addMoreItem_s');
            if (tbody) {
                const sortable = new Sortable(tbody, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        // Update serial numbers and form field names after drag
                        updateSerialNumbers();
                        // Reinitialize select2 after reordering
                        selectReinitialize();
                    }
                });
            }
        });
    </script>
    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #f0f0f0;
        }

        .sortable-chosen {
            cursor: grabbing !important;
        }

        .sortable-drag {
            opacity: 0.8;
        }

        .drag-handle {
            cursor: grab;
        }

        .drag-handle:active {
            cursor: grabbing;
        }
    </style>
@endpush