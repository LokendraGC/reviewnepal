<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route('backend.dashboard') }}" class="logo logo-light">
        <span class="logo-lg text-white pt-3">
            {{-- <img src="/images/logo.png" alt="logo"> --}}
            <h4>Admin Panel</h4>
            <hr />
        </span>
        <span class="logo-sm text-white pt-2">
            {{-- <img src="/images/logo-sm.png" alt="small logo"> --}}
            <h6>Admin Panel</h6>
            <hr />
        </span>
    </a>

    <!-- Brand Logo Dark -->
    {{-- <a href="{{ route('backend.dashboard') }}" class="logo logo-dark">
    <span class="logo-lg">
        <img src="/images/logo-dark.png" alt="logo">
    </span>
    <span class="logo-sm">
        <img src="/images/logo-sm.png" alt="small logo">
    </span>
    </a> --}}

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="{{ route('second', ['pages', 'profile']) }}">
                <img src="/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Tosha Minner</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            {{-- <li class="side-nav-title">Navigation</li> --}}
            <li class="side-nav-title text-success">Dashboard</li>
            <li class="side-nav-item">
                <a href="{{ route('backend.dashboard') }}" class="side-nav-link">
                    <i class="ri-apps-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            @can(['read_site_settings', 'update_site_settings'])
            <li class="side-nav-title text-success">Site Management</li>
            <li class="side-nav-item">
                <a href="{{ route('backend.setting') }}" class="side-nav-link">
                    <i class="ri-settings-5-line"></i>
                    <span> Site Settings </span>
                </a>
            </li>
            @endcan

            <li class="side-nav-title text-success">Ads Management</li>
            <li class="side-nav-item">
                <a href="{{ route('backend.ads.setting') }}" class="side-nav-link">
                    <i class="ri-settings-5-line"></i>
                    <span> Ads Settings </span>
                </a>
            </li>

            @can(['read_menu'])
            <li class="side-nav-item {{ request()->segment(2) === 'menu' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#menus" aria-expanded="false" aria-controls="menus"
                    class="side-nav-link">
                    <i class="ri-menu-line"></i>
                    <span> Menus </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(2) === 'menu' ? 'show' : '' }}" id="menus">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('backend.menu') }}">All Menu</a>
                        </li>
                        @can(['create_menu'])
                        <li>
                            <a href="{{ route('backend.menu.create') }}">Add New Menu</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcan

            <li class="side-nav-title text-success">Content Management</li>
            @canany(['create_post', 'read_post'])
            <li class="side-nav-item {{ request()->segment(2) === 'post' && !in_array(request()->segment(3), ['category', 'author', 'tag']) ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#post" aria-expanded="false" aria-controls="post"
                    class="side-nav-link">
                    <i class="ri-file-ppt-line"></i>
                    <span> English Posts </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(2) === 'post' && !in_array(request()->segment(3), ['category', 'author', 'tag']) ? 'show' : '' }}" id="post">
                    <ul class="side-nav-second-level">
                        @can('read_post')
                        <li>
                            <a href="{{ route('backend.post') }}">All Posts</a>
                        </li>
                        @endcan
                        @can('create_post')
                        <li>
                            <a href="{{ route('backend.post.create') }}">Add New Post</a>
                        </li>
                        @endcan
                        @can(['create_category', 'read_category'])
                        <!-- <li
                            class="{{ request()->segment(3) === 'category' && request()->segment(2) === 'post' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('backend.category') }}">Categories</a>
                        </li> -->
                        @endcan

                        <!-- <li
                            class="{{ request()->segment(3) === 'author' && request()->segment(2) === 'post' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('backend.author') }}">Authors</a>
                        </li> -->

                    </ul>
                </div>
            </li>
            @endcanany

            @canany(['create_post', 'read_post'])
            <li class="side-nav-item {{ request()->segment(2) === 'post_ne' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#post_ne" aria-expanded="false" aria-controls="post_ne"
                    class="side-nav-link">
                    <i class="ri-file-ppt-line"></i>
                    <span> Nepali Posts </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(2) === 'post_ne' ? 'show' : '' }}" id="post_ne">
                    <ul class="side-nav-second-level">
                        @can('read_post')
                        <li>
                            <a href="{{ route('backend.post_ne') }}">All Posts</a>
                        </li>
                        @endcan
                        @can('create_post')
                        <li>
                            <a href="{{ route('backend.post_ne.create') }}">Add New Post</a>
                        </li>
                        @endcan

                    </ul>
                </div>
            </li>
            @endcanany

            @can(['create_category', 'read_category'])
            <li class="side-nav-item {{ request()->segment(3) === 'category' ? 'menuitem-active' : '' }}">
                <a href="{{ route('backend.category') }}" class="side-nav-link">
                    <i class="ri-file-list-3-line"></i>
                    <span> Categories </span>
                </a>
            </li>
            @endcan


            <li class="side-nav-item {{ request()->segment(3) === 'author' ? 'menuitem-active' : '' }}">
                <a href="{{ route('backend.author') }}" class="side-nav-link">
                    <i class="ri-user-3-line"></i>
                    <span> Authors </span>
                </a>
            </li>


            <li class="side-nav-item {{ request()->segment(2) === 'page' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#pages" aria-expanded="false" aria-controls="pages"
                    class="side-nav-link">
                    <i class="ri-file-copy-line"></i>
                    <span> Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(2) === 'page' ? 'show' : '' }}" id="pages">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('backend.page') }}">All Page</a>
                        </li>
                        <li>
                            <a href="{{ route('backend.page.create') }}">Add New Page</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="side-nav-item {{ request()->segment(2) === 'team' ? 'menuitem-active' : '' }}">
            <a data-bs-toggle="collapse" href="#team" aria-expanded="false" aria-controls="team"
                class="side-nav-link">
                <i class="ri-team-line"></i>
                <span> Teams </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse {{ request()->segment(2) === 'team' ? 'show' : '' }}" id="team">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('backend.team') }}">All Teams</a>
                    </li>
                    @can('create_team')
                    <li>
                        <a href="{{ route('backend.team.create') }}">Add New Team</a>
                    </li>
                    @endcan
                </ul>
            </div>
            </li> --}}

            <li class="side-nav-title text-success">Users & Access</li>
            <li
                class="side-nav-item {{ request()->segment(3) === 'user' || request()->segment(2) === 'user' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user"
                    class="side-nav-link">
                    <i class="ri-account-box-line"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(3) === 'user' || request()->segment(2) === 'user' ? 'show' : '' }}"
                    id="user">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('backend.user') }}">All Users</a>
                        </li>
                        @can('create_user')
                        <li>
                            <a href="{{ route('backend.user.create') }}">Add New</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('backend.user.profile') }}">Profile</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li
                class="side-nav-item {{ request()->segment(3) === 'general' || request()->segment(2) === 'general' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#appearance" aria-expanded="false" aria-controls="appearance"
                    class="side-nav-link">
                    <i class="ri-settings-2-line"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(3) === 'general' || request()->segment(2) === 'general' ? 'show' : '' }}"
                    id="appearance">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->segment(3) === 'general' || request()->segment(2) === 'general' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('backend.general.setting') }}">General</a>
                        </li>
                        <li class="{{ request()->segment(2) === 'appearance' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('backend.appearance.setting') }}">Appearance</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title text-success">Logout</li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}" class="side-nav-link"
                    onclick="return confirm('Are you sure you want to logout?');">
                    <i class="ri-logout-box-r-line"></i>
                    <span> Logout </span>
                </a>
            </li>

            @role('Super Admin')
            <li class="side-nav-title text-success">Account Management</li>

            <li
                class="side-nav-item {{ request()->segment(3) === 'role' || request()->segment(2) === 'role' ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#role-permission" aria-expanded="false"
                    aria-controls="role-permission" class="side-nav-link">
                    <i class="ri-user-line"></i>
                    <span> Role Management </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(3) === 'role' || request()->segment(2) === 'role' ? 'show' : '' }}"
                    id="role-permission">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->segment(3) === 'role' || request()->segment(2) === 'role' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('backend.role') }}">Roles</a>
                        </li>
                        <li>
                            <a href="{{ route('backend.permission') }}">Permissions</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Apps</li>

            <li class="side-nav-item">
                <a href="{{ route('second', ['apps', 'calendar']) }}" class="side-nav-link">
                    <i class="ri-calendar-event-line"></i>
                    <span> Calendar </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('second', ['apps', 'chat']) }}" class="side-nav-link">
                    <i class="ri-message-3-line"></i>
                    <span> Chat </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail"
                    class="side-nav-link">
                    <i class="ri-mail-line"></i>
                    <span> Email </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmail">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['email', 'inbox']) }}">Inbox</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['email', 'read']) }}">Read Email</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false" aria-controls="sidebarTasks"
                    class="side-nav-link">
                    <i class="ri-task-line"></i>
                    <span> Tasks </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTasks">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['task', 'list']) }}">List</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['task', 'details']) }}">Details</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('second', ['apps', 'kanban']) }}" class="side-nav-link">
                    <i class="ri-list-check-3"></i>
                    <span> Kanban Board </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('second', ['apps', 'file-manager']) }}" class="side-nav-link">
                    <i class="ri-folder-2-line"></i>
                    <span> File Manager </span>
                </a>
            </li>

            <li class="side-nav-title">Custom</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages"
                    class="side-nav-link">
                    <i class="ri-pages-line"></i>
                    <span> Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPages">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['pages', 'profile']) }}">Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'invoice']) }}">Invoice</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'faq']) }}">FAQ</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'pricing']) }}">Pricing</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'maintenance']) }}">Maintenance</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'starter']) }}">Starter Page</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'preloader']) }}">With Preloader</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['pages', 'timeline']) }}">Timeline</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false"
                    aria-controls="sidebarPagesAuth" class="side-nav-link">
                    <i class="ri-shield-user-line"></i>
                    <span> Auth Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPagesAuth">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['auth', 'login']) }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'login-2']) }}">Login 2</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'register']) }}">Register</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'register-2']) }}">Register 2</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'logout']) }}">Logout</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'logout-2']) }}">Logout 2</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'recoverpw']) }}">Recover Password</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'recoverpw-2']) }}">Recover Password 2</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'lock-screen']) }}">Lock Screen</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'lock-screen-2']) }}">Lock Screen 2</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'confirm-mail']) }}">Confirm Mail</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['auth', 'confirm-mail-2']) }}">Confirm Mail 2</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPagesError" aria-expanded="false"
                    aria-controls="sidebarPagesError" class="side-nav-link">
                    <i class="ri-error-warning-line"></i>
                    <span> Error Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPagesError">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['error', '404']) }}">Error 404</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['error', '404-alt']) }}">Error 404-alt</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['error', '500']) }}">Error 500</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false"
                    aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="ri-layout-line"></i>
                    <span> Layouts </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                    <ul class="side-nav-second-level">
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'horizontal']) }}"><span
                                    class="menu-text">Horizontal</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'detached']) }}"><span
                                    class="menu-text">Detached</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'full-view']) }}"><span
                                    class="menu-text">Full View</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'fullscreen-view']) }}"><span
                                    class="menu-text">Fullscreen View</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'hover-menu']) }}"><span
                                    class="menu-text">Hover Menu</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'compact']) }}"><span
                                    class="menu-text">Compact</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" target="_blank"
                                href="{{ route('second', ['layouts-eg', 'icon-view']) }}"><span
                                    class="menu-text">Icon View</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Components</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false"
                    aria-controls="sidebarBaseUI" class="side-nav-link">
                    <i class="ri-briefcase-line"></i>
                    <span> Base UI </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarBaseUI">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['ui', 'accordions']) }}">Accordions</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'alerts']) }}">Alerts</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'avatars']) }}">Avatars</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'badges']) }}">Badges</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'breadcrumb']) }}">Breadcrumb</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'buttons']) }}">Buttons</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'cards']) }}">Cards</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'carousel']) }}">Carousel</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'collapse']) }}">Collapse</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'dropdowns']) }}">Dropdowns</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'embed-video']) }}">Embed Video</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'grid']) }}">Grid</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'links']) }}">Links</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'list-group']) }}">List Group</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'modals']) }}">Modals</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'notifications']) }}">Notifications</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'offcanvas']) }}">Offcanvas</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'placeholders']) }}">Placeholders</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'pagination']) }}">Pagination</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'popovers']) }}">Popovers</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'progress']) }}">Progress</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'spinners']) }}">Spinners</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'tabs']) }}">Tabs</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'tooltips']) }}">Tooltips</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'typography']) }}">Typography</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['ui', 'utilities']) }}">Utilities</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarExtendedUI" aria-expanded="false"
                    aria-controls="sidebarExtendedUI" class="side-nav-link">
                    <i class="ri-stack-line"></i>
                    <span> Extended UI </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarExtendedUI">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['extended', 'dragula']) }}">Dragula</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['extended', 'range-slider']) }}">Range Slider</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['extended', 'ratings']) }}">Ratings</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['extended', 'scrollbar']) }}">Scrollbar</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['extended', 'scrollspy']) }}">Scrollspy</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('any', 'widgets') }}" class="side-nav-link">
                    <i class="ri-pencil-ruler-2-line"></i>
                    <span> Widgets </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="false" aria-controls="sidebarIcons"
                    class="side-nav-link">
                    <i class="ri-service-line"></i>
                    <span> Icons </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarIcons">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['icons', 'remixicons']) }}">Remix Icons</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['icons', 'bootstrapicons']) }}">Bootstrap Icons</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCharts" aria-expanded="false"
                    aria-controls="sidebarCharts" class="side-nav-link">
                    <i class="ri-bar-chart-line"></i>
                    <span> Charts </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCharts">
                    <ul class="side-nav-second-level">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarApexCharts" aria-expanded="false"
                                aria-controls="sidebarApexCharts">
                                <span> Apex Charts </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarApexCharts">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-area']) }}">Area</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-bar']) }}">Bar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-bubble']) }}">Bubble</a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('second', ['charts', 'apex-candlestick']) }}">Candlestick</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-column']) }}">Column</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-heatmap']) }}">Heatmap</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-line']) }}">Line</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-mixed']) }}">Mixed</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-timeline']) }}">Timeline</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-boxplot']) }}">Boxplot</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-treemap']) }}">Treemap</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-pie']) }}">Pie</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-radar']) }}">Radar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-radialbar']) }}">RadialBar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-scatter']) }}">Scatter</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-polar-area']) }}">Polar Area</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'apex-sparklines']) }}">Sparklines</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarChartJSCharts" aria-expanded="false"
                                aria-controls="sidebarChartJSCharts">
                                <span> ChartJS </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarChartJSCharts">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('second', ['charts', 'chartjs-area']) }}">Area</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'chartjs-bar']) }}">Bar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'chartjs-line']) }}">Line</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('second', ['charts', 'chartjs-other']) }}">Other</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarForms" aria-expanded="false" aria-controls="sidebarForms"
                    class="side-nav-link">
                    <i class="ri-survey-line"></i>
                    <span> Forms </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarForms">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['forms', 'elements']) }}">Basic Elements</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['forms', 'advanced']) }}">Form Advanced</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['forms', 'validation']) }}">Validation</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['forms', 'wizard']) }}">Wizard</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['forms', 'fileuploads']) }}">File Uploads</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['forms', 'editors']) }}">Editors</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTables" aria-expanded="false"
                    aria-controls="sidebarTables" class="side-nav-link">
                    <i class="ri-table-line"></i>
                    <span> Tables </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTables">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['tables', 'basic']) }}">Basic Tables</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['tables', 'datatable']) }}">Data Tables</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMaps" aria-expanded="false" aria-controls="sidebarMaps"
                    class="side-nav-link">
                    <i class="ri-treasure-map-line"></i>
                    <span> Maps </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMaps">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('second', ['maps', 'google']) }}">Google Maps</a>
                        </li>
                        <li>
                            <a href="{{ route('second', ['maps', 'vector']) }}">Vector Maps</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false"
                    aria-controls="sidebarMultiLevel" class="side-nav-link">
                    <i class="ri-share-line"></i>
                    <span> Multi Level </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMultiLevel">
                    <ul class="side-nav-second-level">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false"
                                aria-controls="sidebarSecondLevel">
                                <span> Second Level </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarSecondLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="javascript: void(0);">Item 1</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">Item 2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false"
                                aria-controls="sidebarThirdLevel">
                                <span> Third Level </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarThirdLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="javascript: void(0);">Item 1</a>
                                    </li>
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarFourthLevel" aria-expanded="false"
                                            aria-controls="sidebarFourthLevel">
                                            <span> Item 2 </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarFourthLevel">
                                            <ul class="side-nav-forth-level">
                                                <li>
                                                    <a href="javascript: void(0);">Item 2.1</a>
                                                </li>
                                                <li>
                                                    <a href="javascript: void(0);">Item 2.2</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->