<div class="mb-3">
    <div class="card">
        <div class="card-body">
            <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                <h4 class="header-title">Home Page Builder</h4>
            </div>
            <div class="tab-heading">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#breaking" data-bs-toggle="tab"
                            aria-expanded="{{ !request()->has('tab') || request()->query('tab') == 'breaking' ? 'true' : 'false' }}"
                            class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'breaking' ? 'active' : '' }}">
                            General
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab"
                            aria-expanded="{{ request()->query('tab') == 'banner' ? 'true' : 'false' }}"
                            class="nav-link {{ request()->query('tab') == 'banner' ? 'active' : '' }}">
                            Banner
                        </a>
                    </li> --}}
                </ul>
            </div>
            <div class="tab-content">

            </div>
        </div>
    </div>
</div>
