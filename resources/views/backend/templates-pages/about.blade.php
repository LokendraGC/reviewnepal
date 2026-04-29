<div class="mb-3">
    <div class="card">
        <div class="card-body">
            <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                <h4 class="header-title">About Page Builder</h4>
            </div>
            <div class="tab-heading">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#main-content" data-bs-toggle="tab"
                            aria-expanded="{{ !request()->has('tab') || request()->query('tab') == 'main-content' ? 'true' : 'false' }}"
                            class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'main-content' ? 'active' : '' }}">
                            Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#mission-vision" data-bs-toggle="tab"
                            aria-expanded="{{ request()->query('tab') == 'mission-vision' ? 'true' : 'false' }}"
                            class="nav-link {{ request()->query('tab') == 'mission-vision' ? 'active' : '' }}">
                            Mission & Vision
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#commitment" data-bs-toggle="tab"
                            aria-expanded="{{ request()->query('tab') == 'commitment' ? 'true' : 'false' }}"
                            class="nav-link {{ request()->query('tab') == 'commitment' ? 'active' : '' }}">
                            Commitment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#team" data-bs-toggle="tab"
                            aria-expanded="{{ request()->query('tab') == 'team' ? 'true' : 'false' }}"
                            class="nav-link {{ request()->query('tab') == 'team' ? 'active' : '' }}">
                            Our Team
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#faqs" data-bs-toggle="tab"
                            aria-expanded="{{ request()->query('tab') == 'faqs' ? 'true' : 'false' }}"
                            class="nav-link {{ request()->query('tab') == 'faqs' ? 'active' : '' }}">
                            FAQs
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">

                <!-- main content -->
                <div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') === 'main-content' ? 'active show' : '' }}"
                    id="main-content" role="tabpanel">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="established_title" class="form-label">Established Title</label>
                            <input type="text" class="form-control" id="established_title" name="established_title"
                                value="{{ isset($metaDatas['established_title']) ? $metaDatas['established_title'] : '' }}" />
                        </div>

                        <div class="col-md-6">
                            <label for="established_date" class="form-label">Established Date</label>
                            <input type="text" class="form-control" id="established_date" name="established_date"
                                value="{{ isset($metaDatas['established_date']) ? $metaDatas['established_date'] : '' }}" />
                        </div>
                    </div>
                    <hr>

                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="about_first_image" class="form-label">About First Image</label>
                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="cursor: pointer;"
                                        data-field="about_first_image" data-select="single">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                Browse</div>
                                        </div>

                                        <div class="form-control file-amount">Choose File</div>
                                    </div>
                                    <div class="preview-closer">
                                        @if (isset($metaDatas['about_first_image']) &&
                                        ($media = MediaHelper::getModel()->where('id', $metaDatas['about_first_image'])->first()))
                                        <input type="hidden" id="about_first_image"
                                            name="about_first_image" class="selected-files"
                                            value="{{ $metaDatas['about_first_image'] }}">
                                        <div id="about_first_image_select">
                                            <div class="file-preview box sm">
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                    <div
                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                        <img class="img-fit"
                                                            src="{{ asset('storage/' . $media->file_name) }}"
                                                            alt="image" />
                                                    </div>
                                                    <div class="col body">
                                                        <h6 class="d-flex">
                                                            <span
                                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                                            <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                        </h6>
                                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}</p>
                                                    </div>
                                                    <div class="remove"><button data-id="{{ $media->id }}"
                                                            data-slug="about_first_image"
                                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                                class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" id="about_first_image"
                                            name="about_first_image" class="selected-files" value="" />
                                        <div id="about_first_image_select"></div>
                                        @endisset
                                    </div>
                                    <span class="form-text text-muted">
                                        <small><i>Recommended Image size: 3149 by 4724 px</i></small>
                                    </span>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="about_second_image" class="form-label">About Second Image</label>
                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="cursor: pointer;"
                                        data-field="about_second_image" data-select="single">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                Browse</div>
                                        </div>

                                        <div class="form-control file-amount">Choose File</div>
                                    </div>
                                    <div class="preview-closer">
                                        @if (isset($metaDatas['about_second_image']) &&
                                        ($media = MediaHelper::getModel()->where('id', $metaDatas['about_second_image'])->first()))
                                        <input type="hidden" id="about_second_image"
                                            name="about_second_image" class="selected-files"
                                            value="{{ $metaDatas['about_second_image'] }}">
                                        <div id="about_second_image_select">
                                            <div class="file-preview box sm">
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                    <div
                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                        <img class="img-fit"
                                                            src="{{ asset('storage/' . $media->file_name) }}"
                                                            alt="image" />
                                                    </div>
                                                    <div class="col body">
                                                        <h6 class="d-flex">
                                                            <span
                                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                                            <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                        </h6>
                                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}</p>
                                                    </div>
                                                    <div class="remove"><button data-id="{{ $media->id }}"
                                                            data-slug="about_second_image"
                                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                                class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" id="about_second_image"
                                            name="about_second_image" class="selected-files" value="" />
                                        <div id="about_second_image_select"></div>
                                        @endisset
                                    </div>
                                    <span class="form-text text-muted">
                                        <small><i>Recommended Image size: 4016 by 6016 px</i></small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- mission vision -->
                <div class="tab-pane {{ request()->query('tab') == 'mission-vision' ? 'show active' : '' }}" id="mission-vision">
                    <div class="row mb-3">
                        {{-- Details --}}
                        <div class="mb-3">
                            <label class="form-label">Mission & Vision</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="custom-table-sno" style="width:5%">S.No</th>
                                            <th style="width:20%">Title</th>
                                            <th style="width:20%">Description</th>
                                            <th style="width:20%">Upload Image
                                                <span class="form-text text-muted">
                                                    <small><i>(Recommended image size: 895 by 495 px)</i></small>
                                                </span>
                                            </th>
                                            <th style="width:10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreMissionVision">
                                        @isset($metaDatas['mission_and_vision_details'])
                                        @php
                                        $missionAndVisionDetails = unserialize($metaDatas['mission_and_vision_details']);
                                        @endphp

                                        @foreach ($missionAndVisionDetails as $index => $item)
                                        {{-- Fixed variable name --}}
                                        <tr>
                                            <td class="custom-table-no">{{ $loop->iteration }}</td>
                                            <td>
                                                <input type="text"
                                                    name="mission_and_vision_details[{{ $index }}][title]"
                                                    class="form-control"
                                                    value="{{ isset($item['title']) ? $item['title'] : '' }}" />
                                            </td>
                                            <td>
                                                <textarea class="editor" id="content" name="mission_and_vision_details[{{ $index }}][description]"
                                                    rows="5">{{ isset($item['description']) ? $item['description'] : '' }}</textarea>
                                            </td>
                                            <td>
                                                <div class="media-input image-input">
                                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal" style="cursor: pointer;"
                                                        data-field="mission_and_vision_details_{{ $index }}_image"
                                                        data-select="single">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text bg-soft-secondary font-weight-medium">
                                                                Browse
                                                            </div>
                                                        </div>
                                                        <div class="form-control file-amount">Choose File</div>
                                                    </div>
                                                    <div class="preview-closer">
                                                        @if (isset($item['image']) && ($media = \App\Models\Media::where('id', $item['image'])->first()))
                                                        <input type="hidden"
                                                            id="mission_and_vision_details_{{ $index }}_image"
                                                            name="mission_and_vision_details[{{ $index }}][image]"
                                                            class="selected-files" value="{{ $item['image'] }}" />
                                                        <div
                                                            id="mission_and_vision_details_{{ $index }}_image_select">
                                                            <div class="file-preview box sm">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                                    <div
                                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                        <img class="img-fit"
                                                                            src="{{ asset('storage/' . $media->file_name) }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="col body">
                                                                        <h6 class="d-flex">
                                                                            <span
                                                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                            <span
                                                                                class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                                        </h6>
                                                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="remove">
                                                                        <button data-id="{{ $item['image'] }}"
                                                                            data-slug="mission_and_vision_details_{{ $index }}_image"
                                                                            class="btn btn-sm btn-link remove-attachment"
                                                                            type="button">
                                                                            <i class="bi bi-x-circle"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <input type="hidden"
                                                            id="mission_and_vision_details_{{ $index }}_image"
                                                            name="mission_and_vision_details[{{ $index }}][image]"
                                                            class="selected-files" value="" />
                                                        <div
                                                            id="mission_and_vision_details_{{ $index }}_image_select">
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a href="javascript:void(0);"
                                                    class="text-success fs-16 px-1 add_more_mission_vision">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    class="text-danger fs-16 px-1 remove_mission_vision">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                                <hr>
                                                <a href="javascript:void(0);" class="text-primary fs-16 px-1 mv-move-up"
                                                    title="Move Up">
                                                    <i class="bi bi-arrow-up-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="text-primary fs-16 px-1 mv-move-down"
                                                    title="Move Down">
                                                    <i class="bi bi-arrow-down-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-primary btn-sm add_mission_vision">Add Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- commitment -->
                <div class="tab-pane {{ request()->query('tab') == 'commitment' ? 'show active' : '' }}" id="commitment">
                    <div class="row mb-3">

                        <div class="mb-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="commitment_bg_image" class="form-label">Upload Background Image</label>
                                        <div class="input-group open-media-manager" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" style="cursor: pointer;"
                                            data-field="commitment_bg_image" data-select="single">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    Browse</div>
                                            </div>

                                            <div class="form-control file-amount">Choose File</div>
                                        </div>
                                        <div class="preview-closer">
                                            @if (isset($metaDatas['commitment_bg_image']) &&
                                            ($media = MediaHelper::getModel()->where('id', $metaDatas['commitment_bg_image'])->first()))
                                            <input type="hidden" id="commitment_bg_image"
                                                name="commitment_bg_image" class="selected-files"
                                                value="{{ $metaDatas['commitment_bg_image'] }}">
                                            <div id="commitment_bg_image_select">
                                                <div class="file-preview box sm">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                        <div
                                                            class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                            <img class="img-fit"
                                                                src="{{ asset('storage/' . $media->file_name) }}"
                                                                alt="image" />
                                                        </div>
                                                        <div class="col body">
                                                            <h6 class="d-flex">
                                                                <span
                                                                    class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                            </h6>
                                                            <p>{{ MediaHelper::getKBorMB($media->file_size) }}</p>
                                                        </div>
                                                        <div class="remove"><button data-id="{{ $media->id }}"
                                                                data-slug="commitment_bg_image"
                                                                class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                                    class="bi bi-x-circle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <input type="hidden" id="commitment_bg_image"
                                                name="commitment_bg_image" class="selected-files" value="" />
                                            <div id="commitment_bg_image_select"></div>
                                            @endisset
                                        </div>
                                        <span class="form-text text-muted">
                                            <small><i>Recommended Image size: 3149 by 4724 px</i></small>
                                        </span>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="mb-1">
                            <textarea class="editor" id="content" name="commitment_description"
                                rows="5">{{ isset($item['commitment_description']) ? $item['commitment_description'] : '' }}</textarea>
                        </div>

                    </div>
                </div>

                <!-- our team -->
                <div class="tab-pane {{ request()->query('tab') == 'team' ? 'show active' : '' }}" id="team">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="team_title" class="form-label">Our Team Title</label>
                            <input type="text" class="form-control" id="team_title" name="team_title"
                                value="{{ isset($metaDatas['team_title']) ? $metaDatas['team_title'] : '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="card">
                                    <div class="card-body">

                                        <div
                                            class="mb-2 d-flex align-content-center border-1 border-bottom">
                                            <h4 class="header-title">Team Details</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="custom-table-sno" style="width:5%">S.No</th>
                                                        <th style="width:15%">Name</th>
                                                        <th style="width:15%">Designation</th>
                                                        <th style="width:15%">Profile Image
                                                            <span class="form-text text-muted">
                                                                <small><i>(Recommended image size: 645 by 620 px)</i></small>
                                                            </span>
                                                        </th>
                                                        <th style="width:15%" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="addMoreTeam">
                                                    @isset($metaDatas['team_details'])
                                                    @php
                                                    $teamDetails = unserialize($metaDatas['team_details']);
                                                    @endphp

                                                    @foreach ($teamDetails as $index => $item)
                                                    {{-- Fixed variable name --}}
                                                    <tr>
                                                        <td class="custom-table-sno">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <input type="text" name="team_details[{{ $index }}][name]"
                                                                class="form-control" value="{{ isset($item['name']) ? $item['name'] : '' }}" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="team_details[{{ $index }}][designation]" class="form-control" value="{{ isset($item['designation']) ? $item['designation'] : '' }}" />
                                                        </td>
                                                        <td>
                                                            <div class="media-input image-input">
                                                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                                                    data-field="team_details_{{ $index }}_image"
                                                                    data-select="single">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                                            Browse
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-control file-amount">Choose File</div>
                                                                </div>
                                                                <div class="preview-closer">
                                                                    @if (isset($item['image']) && ($media = \App\Models\Media::where('id', $item['image'])->first()))
                                                                    <input type="hidden" id="team_details_{{ $index }}_image"
                                                                        name="team_details[{{ $index }}][image]"
                                                                        class="selected-files" value="{{ $item['image'] }}" />
                                                                    <div id="team_details_{{ $index }}_image_select">
                                                                        <div class="file-preview box sm">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                                                <div
                                                                                    class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                                    <img class="img-fit"
                                                                                        src="{{ asset('storage/' . $media->file_name) }}"
                                                                                        alt="">
                                                                                </div>
                                                                                <div class="col body">
                                                                                    <h6 class="d-flex">
                                                                                        <span
                                                                                            class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                                        <span
                                                                                            class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                                                    </h6>
                                                                                    <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="remove">
                                                                                    <button data-id="{{ $item['image'] }}"
                                                                                        data-slug="team_details_{{ $index }}_image"
                                                                                        class="btn btn-sm btn-link remove-attachment"
                                                                                        type="button">
                                                                                        <i class="bi bi-x-circle"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <input type="hidden" id="team_details_{{ $index }}_image"
                                                                        name="team_details[{{ $index }}][image]"
                                                                        class="selected-files" value="" />
                                                                    <div id="team_details_{{ $index }}_image_select">
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>

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
                                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-down"
                                                                title="Move Down">
                                                                <i class="bi bi-arrow-down-circle"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endisset
                                                </tbody>
                                            </table>
                                            <div class="text-end mt-2">
                                                <button type="button" class="btn btn-primary btn-sm add_team">Add
                                                    Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- faqs -->
                <div class="tab-pane {{ request()->query('tab') == 'faqs' ? 'show active' : '' }}" id="faqs">
                    <div class="row mb-3">

                        <div class="col-md-12 mb-3">
                            <label for="faq_title" class="form-label">FAQs Title</label>
                            <input type="text" class="form-control" id="faq_title" name="faq_title"
                                value="{{ isset($metaDatas['faq_title']) ? $metaDatas['faq_title'] : '' }}" />
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="faq_featured_image" class="form-label">FAQ Featured Image</label>
                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="cursor: pointer;"
                                        data-field="faq_featured_image" data-select="single">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                Browse</div>
                                        </div>

                                        <div class="form-control file-amount">Choose File</div>
                                    </div>
                                    <div class="preview-closer">
                                        @if (isset($metaDatas['faq_featured_image']) &&
                                        ($media = MediaHelper::getModel()->where('id', $metaDatas['faq_featured_image'])->first()))
                                        <input type="hidden" id="faq_featured_image"
                                            name="faq_featured_image" class="selected-files"
                                            value="{{ $metaDatas['faq_featured_image'] }}">
                                        <div id="faq_featured_image_select">
                                            <div class="file-preview box sm">
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                    <div
                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                        <img class="img-fit"
                                                            src="{{ asset('storage/' . $media->file_name) }}"
                                                            alt="image" />
                                                    </div>
                                                    <div class="col body">
                                                        <h6 class="d-flex">
                                                            <span
                                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                                            <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                        </h6>
                                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}</p>
                                                    </div>
                                                    <div class="remove"><button data-id="{{ $media->id }}"
                                                            data-slug="faq_featured_image"
                                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                                class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" id="faq_featured_image"
                                            name="faq_featured_image" class="selected-files" value="" />
                                        <div id="faq_featured_image_select"></div>
                                        @endisset
                                    </div>
                                    <span class="form-text text-muted">
                                        <small><i>Recommended Image size: 800 by 800 px</i></small>
                                    </span>
                                </div>
                            </div>
                        </div>


                        {{-- Details --}}
                        <div class="mb-3">
                            <label class="form-label"> Investors Details</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="custom-table-sno" style="width:5%">S.No</th>
                                            <th style="width:25%">Question</th>
                                            <th style="width:25%">Answer</th>
                                            <th style="width:10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreSlider">
                                        @isset($metaDatas['faq_details'])
                                        @php
                                        $investorsDetails = unserialize($metaDatas['faq_details']);
                                        @endphp
                                        @foreach ($investorsDetails as $index => $item)
                                        <tr>
                                            <td class="custom-table-no">{{ $loop->iteration }}</td>
                                            <td>
                                                <input type="text"
                                                    name="faq_details[{{ $index }}][question]"
                                                    class="form-control"
                                                    value="{{ isset($item['question']) ? $item['question'] : '' }}" />
                                            </td>
                                            <td>
                                                <textarea class="editor" id="content" name="faq_details[{{ $index }}][answer]"
                                                    rows="5">{{ isset($item['answer']) ? $item['answer'] : '' }}</textarea>
                                            </td>

                                            <td class="text-center">
                                                <a href="javascript:void(0);"
                                                    class="text-success fs-16 px-1 add_more_slider">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    class="text-danger fs-16 px-1 remove_slider">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                                <hr>
                                                <a href="javascript:void(0);" class="text-primary fs-16 px-1 move-up"
                                                    title="Move Up">
                                                    <i class="bi bi-arrow-up-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    class="text-primary fs-16 px-1 move-down" title="Move Down">
                                                    <i class="bi bi-arrow-down-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-primary btn-sm add_slider">Add Detail</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


@include('backend.templates-pages.about.mission-vision-repeater')
@include('backend.templates-pages.about.team-repeater')
@include('backend.templates-pages.about.faq-repeater')